// ── DATA ──
// Tour, tour-detail, destination, and guide data now live in C# models
// (see Models/ and Data/ in the ASP.NET Core project) and are rendered
// into the page as JSON by Controllers/HomeController.cs + Views/Home/Index.cshtml.
// We just read them off window.__LYNX_DATA__ here so all the rendering/
// filtering/language-toggle logic below can stay exactly as it was.
const toursEn = window.__LYNX_DATA__.toursEn;
const toursMk = window.__LYNX_DATA__.toursMk;
const tourDetailsEn = window.__LYNX_DATA__.tourDetailsEn;
const tourDetailsMk = window.__LYNX_DATA__.tourDetailsMk;

// ── TOUR DETAIL OVERLAY ──
let currentDetailTourId = null;

function openTourDetail(tourId) {
    var tour = {}
    var tourDetails = {}
    tempArray = []
    if (currentLang === 'en') {
        tour = toursEn.find(t => t.id === tourId);
        tourDetails = tourDetailsEn;
        tempArray[0] = 'FROM'
        tempArray[1] = 'PERSON'
        tempArray[2] = 'Book Now'
        tempArray[3] = 'About this tour'
        tempArray[4] = 'Highlights'
        tempArray[5] = 'Itinerary'
        tempArray[6] = 'What\'s included'
        tempArray[7] = 'Your guide'
        tempArray[8] = 'Meeting point'
    } else {
        tour = toursMk.find(t => t.id === tourId);
        tourDetails = tourDetailsMk;
        tempArray[0] = 'ОД'
        tempArray[1] = 'ЧОВЕК'
        tempArray[2] = 'Резервирај Сега'
        tempArray[3] = 'За оваа тура'
        tempArray[4] = 'Позначајно'
        tempArray[5] = 'Рута'
        tempArray[6] = 'Што е вклучено'
        tempArray[7] = 'Водич'
        tempArray[8] = 'Место за сретнување'
    }
    const detail = tourDetails[tourId];
    if (!tour || !detail) return;
    currentDetailTourId = tourId;

    document.getElementById('detailEmoji').src = tour.emoji;
    document.getElementById('detailBadge').textContent = tour.badge;
    document.getElementById('detailTitle').textContent = tour.name;
    document.getElementById('detailRegion').textContent = '📍 ' + tour.region;

    document.getElementById('detailPills').innerHTML = `
            <div class="detail-pill">🕐 ${tour.duration}</div>
            <div class="detail-pill">📊 ${tour.difficulty}</div>
            <div class="detail-pill">📅 Best: ${detail.bestSeason}</div>
            <div class="detail-pill">👥 ${detail.groupSize}</div>
        `;

    // Build body
    let itineraryHTML = detail.itinerary.map((day, i) => `
            <div class="detail-day">
                <div class="detail-day-num">${i + 1}</div>
                <div class="detail-day-content">
                    <h4>${day.title}</h4>
                    <p>${day.desc}</p>
                </div>
            </div>
        `).join('');

    let highlightsHTML = detail.highlights.map(h => `<div class="detail-highlight">${h}</div>`).join('');
    let includesHTML = detail.includes.map(inc => `
            <div class="detail-include">
                <span class="detail-include-icon">${inc.split(' ')[0]}</span>
                <span>${inc.split(' ').slice(1).join(' ')}</span>
            </div>
        `).join('');

    document.getElementById('detailBody').innerHTML = `
            <div class="detail-price-row">
                <div>
                    <div class="detail-price-label">${tempArray[0]}</div>
                    <div class="detail-price-val">€${tour.price}<span>/${tempArray[1]}</span></div>
                </div>
                <a href="#booking" class="detail-book-btn" onclick="closeTourDetail(); setBookingTour('${tour.name}')">${tempArray[2]} →</a>
            </div>

            <div class="detail-section">
                <div class="detail-section-title">${tempArray[3]}</div>
                <p class="detail-desc">${detail.longDesc}</p>
            </div>

            <div class="detail-section">
                <div class="detail-section-title">${tempArray[4]}</div>
                <div class="detail-highlights">${highlightsHTML}</div>
            </div>

            <div class="detail-section">
                <div class="detail-section-title">${tempArray[5]}</div>
                <div class="detail-itinerary">${itineraryHTML}</div>
            </div>

            <div class="detail-section">
                <div class="detail-section-title">${tempArray[6]}</div>
                <div class="detail-includes">${includesHTML}</div>
            </div>

            <div class="detail-section">
                <div class="detail-section-title">${tempArray[7]}</div>
                <div class="detail-guide">
                    <div class="detail-guide-avatar">${detail.guide.avatar}</div>
                    <div>
                        <div class="detail-guide-name">${detail.guide.name}</div>
                        <div class="detail-guide-role">${detail.guide.role}</div>
                    </div>
                </div>
            </div>

            <div class="detail-section" style="background:rgba(201,146,58,0.06);border:1px solid rgba(201,146,58,0.2);border-radius:10px;padding:1rem 1.25rem;">
                <div class="detail-section-title" style="border-bottom-color:rgba(201,146,58,0.15);">${tempArray[8]}</div>
                <p class="detail-desc">📍 ${detail.meetingPoint}</p>
            </div>
        `;

    // Update save button state
    updateDetailSaveBtn(tourId);

    document.getElementById('tourDetailOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeTourDetail() {
    document.getElementById('tourDetailOverlay').classList.remove('open');
    document.body.style.overflow = '';
    currentDetailTourId = null;
}

function closeDetailOverlay(e) {
    if (e.target === document.getElementById('tourDetailOverlay')) closeTourDetail();
}

function toggleDetailSave() {
    if (!currentDetailTourId) return;
    const t = tours.find(t => t.id === currentDetailTourId);
    if (!t) return;
    // Find the save button in the grid card and simulate a click
    if (savedTours.has(currentDetailTourId)) {
        savedTours.delete(currentDetailTourId);
    } else {
        savedTours.add(currentDetailTourId);
        if (cookiesAccepted) setCookie(LAST_VIEWED_KEY, t.name, 30);
    }
    if (cookiesAccepted) setCookie(SAVED_TOURS_KEY, JSON.stringify([...savedTours]), 30);
    updateSavedUI();
    updateDetailSaveBtn(currentDetailTourId);
    // Sync the card in the grid
    const card = document.querySelector(`.tour-card[data-id="${currentDetailTourId}"]`);
    if (card) {
        card.classList.toggle('saved', savedTours.has(currentDetailTourId));
        const btn = card.querySelector('.save-btn');
        if (btn) {
            btn.textContent = savedTours.has(currentDetailTourId) ? '♥' : '♡';
            btn.classList.toggle('saved', savedTours.has(currentDetailTourId));
        }
    }
}

function updateDetailSaveBtn(tourId) {
    const btn = document.getElementById('detailSaveBtn');
    if (!btn) return;
    const saved = savedTours.has(tourId);
    btn.textContent = saved ? '♥ Saved' : '♡ Save';
    btn.classList.toggle('saved', saved);
}

function setBookingTour(tourName) {
    const sel = document.getElementById('tourSelect');
    if (sel) {
        for (let opt of sel.options) {
            if (opt.text === tourName) {
                sel.value = opt.value || tourName;
                break;
            }
        }
    }
}

// Close on Escape key
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeTourDetail();
});


const destinationsEn = window.__LYNX_DATA__.destinationsEn;
const destinationsMk = window.__LYNX_DATA__.destinationsMk;

// ── STATE & COOKIES ──
let savedTours = new Set();
let cookiesAccepted = false;
let currentLang = 'en';

const COOKIE_CONSENT_KEY = 'lynx_cookie_consent';
const SAVED_TOURS_KEY = 'lynx_saved_tours';
const FORM_DATA_KEY = 'lynx_form_data';
const LAST_VIEWED_KEY = 'lynx_last_viewed';

function getCookie(name) {
    const m = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
    return m ? decodeURIComponent(m.pop()) : null;
}

function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + days * 864e5);
    document.cookie = name + '=' + encodeURIComponent(value) + ';expires=' + d.toUTCString() + ';path=/;SameSite=Lax';
}

function acceptCookies() {
    setCookie(COOKIE_CONSENT_KEY, 'true', 365);
    cookiesAccepted = true;
    document.getElementById('cookieBanner').classList.remove('show');
    saveFormDataContinuously();
    showWelcomeBackIfReturning();
}

function declineCookies() {
    document.getElementById('cookieBanner').classList.remove('show');
}

function initCookies() {
    const consent = getCookie(COOKIE_CONSENT_KEY);
    if (consent === 'true') {
        cookiesAccepted = true;
        loadSavedData();
        showWelcomeBackIfReturning();
        saveFormDataContinuously();
    } else {
        setTimeout(() => document.getElementById('cookieBanner').classList.add('show'), 1500);
    }
}

function loadSavedData() {
    const saved = getCookie(SAVED_TOURS_KEY);
    if (saved) {
        try {
            savedTours = new Set(JSON.parse(saved));
        } catch (e) {
        }
    }
    const formData = getCookie(FORM_DATA_KEY);
    if (formData) {
        try {
            const d = JSON.parse(formData);
            if (d.firstName) document.getElementById('firstName').value = d.firstName;
            if (d.lastName) document.getElementById('lastName').value = d.lastName;
            if (d.email) document.getElementById('email').value = d.email;
            if (d.phone) document.getElementById('phone').value = d.phone;
        } catch (e) {
        }
    }
    const lastTour = getCookie(LAST_VIEWED_KEY);
    if (lastTour && savedTours.size > 0) {
        const notice = document.getElementById('savedTourNotice');
        notice.textContent = `🐾 We remembered your saved tours! We've pre-selected "${lastTour}" for you.`;
        notice.classList.add('show');
        document.getElementById('tourSelect').value = lastTour;
    }
}

function showWelcomeBackIfReturning() {
    const lastTour = getCookie(LAST_VIEWED_KEY);
    if (lastTour) {
        const banner = document.getElementById('welcomeBack');
        document.getElementById('welcomeBackTour').textContent = lastTour;
        banner.classList.add('show');
        setTimeout(() => banner.classList.remove('show'), 5000);
    }
}

function saveFormDataContinuously() {
    const fields = ['firstName', 'lastName', 'email', 'phone'];
    fields.forEach(id => {
        document.getElementById(id).addEventListener('input', saveFormData);
    });
}

function saveFormData() {
    if (!cookiesAccepted) return;
    const d = {
        firstName: document.getElementById('firstName').value,
        lastName: document.getElementById('lastName').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
    };
    setCookie(FORM_DATA_KEY, JSON.stringify(d), 7);
}

function toggleSaveTour(tourId, tourName, btn) {
    if (savedTours.has(tourId)) {
        savedTours.delete(tourId);
        btn.classList.remove('saved');
        btn.textContent = '♡';
        btn.closest('.tour-card').classList.remove('saved');
    } else {
        savedTours.add(tourId);
        btn.classList.add('saved');
        btn.textContent = '♥';
        btn.closest('.tour-card').classList.add('saved');
        if (cookiesAccepted) setCookie(LAST_VIEWED_KEY, tourName, 30);
    }
    if (cookiesAccepted) setCookie(SAVED_TOURS_KEY, JSON.stringify([...savedTours]), 30);
    updateSavedUI();
}

function updateSavedUI() {
    const count = savedTours.size;
    document.getElementById('savedCount').textContent = count;
    const btn = document.getElementById('savedToggleBtn');
    if (count > 0) btn.classList.add('show'); else btn.classList.remove('show');
    const list = document.getElementById('savedSidebarList');
    list.innerHTML = '';
    savedTours.forEach(id => {
        const t = tours.find(t => t.id === id);
        if (t) {
            const el = document.createElement('div');
            el.className = 'saved-sidebar-item';
            el.textContent = t.name;
            list.appendChild(el);
        }
    });
}

function toggleSavedSidebar() {
    document.getElementById('savedSidebar').classList.toggle('show');
}

// ── RENDER TOURS ──
let tours = {}
function renderTours(filter = 'all') {
    var tempOne = ''
    var tempTwo = ''
    if (currentLang === 'en') {
        tours = toursEn;
        tempOne = 'person'
        tempTwo = 'View details →'
    } else {
        tours = toursMk;
        tempOne = 'човек'
        tempTwo = 'Види детали →'
        if (filter === 'nature') {
            filter = 'природа'
        }
        if (filter === 'cultural') {
            filter = 'културни'
        }
        if (filter === 'adventure') {
            filter = 'авантура'
        }
        if (filter === 'winter') {
            filter = 'зима'
        }
    }
    const grid = document.getElementById('toursGrid');
    grid.innerHTML = '';
    const filtered = filter === 'all' ? tours : tours.filter(t => t.category === filter);
    filtered.forEach(t => {
        const isSaved = savedTours.has(t.id);
        const card = document.createElement('div');
        card.className = 'tour-card fade-in' + (isSaved ? ' saved' : '');
        card.dataset.category = t.category;
        card.dataset.id = t.id;
        card.innerHTML = `
      <div class="tour-img" style="background: linear-gradient(135deg, #1A2B1F 0%, #2E4535 100%)">
        <div class="tour-img-inner"><img src="${t.emoji}"></div>
        <div class="tour-badge">${t.badge}</div>
        <button class="save-btn ${isSaved ? 'saved' : ''}" onclick="event.stopPropagation(); toggleSaveTour(${t.id}, '${t.name}', this)" title="Save tour">
          ${isSaved ? '♥' : '♡'}
        </button>
      </div>
      <div class="tour-body">
        <div class="tour-region">${t.region}</div>
        <h3 class="tour-name">${t.name}</h3>
        <p class="tour-desc">${t.desc}</p>
        <div class="tour-meta">
          <div class="tour-details">
            <span class="tour-detail">🕐 ${t.duration}</span>
            <span class="tour-detail">📊 ${t.difficulty}</span>
          </div>
          <div class="tour-price">€${t.price}<span>/${tempOne}</span></div>
        </div>
        <div style="margin-top:0.85rem;padding-top:0.85rem;border-top:1px solid rgba(26,43,31,0.07);">
          <span style="font-size:0.78rem;color:var(--amber);font-weight:600;letter-spacing:0.04em;">${tempTwo}</span>
        </div>
      </div>
    `;
        card.addEventListener('click', () => openTourDetail(t.id));
        grid.appendChild(card);
        setTimeout(() => card.classList.add('visible'), 50);
    });
}

function filterTours(cat, btn) {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    renderTours(cat);
}

// ── RENDER DESTINATIONS ──
let destinations = {}
function renderDestinations() {
    if (currentLang === 'en') {
        destinations = destinationsEn;
    } else {
        destinations = destinationsMk;
    }
    const list = document.getElementById('destList');
    list.innerHTML = '';
    destinations.forEach((d, i) => {
        const el = document.createElement('div');
        el.className = 'dest-item fade-in' + (i === 0 ? ' active' : '');
        el.id = 'dest' + i;
        el.innerHTML = `
      <div class="dest-icon">${d.icon}</div>
      <div class="dest-info">
        <div class="dest-name">${d.name}</div>
        <div class="dest-tag">${d.tag}</div>
      </div>
      <div class="dest-count">${d.count}</div>
    `;
        el.onclick = () => selectDest(i);
        list.appendChild(el);
        setTimeout(() => el.classList.add('visible'), 100 * i);
    });
}

function selectDest(idx) {
    document.querySelectorAll('.dest-item').forEach((el, i) => {
        el.classList.toggle('active', i === idx);
    });
    destinations.forEach((d, i) => {
        const pin = document.getElementById(d.pinId);
        if (!pin) return;
        const circle = pin.querySelector('circle:last-of-type');
        if (i === idx) {
            circle.setAttribute('fill', '#C9923A');
            circle.setAttribute('r', '9');
        } else {
            circle.setAttribute('fill', '#8FA394');
            circle.setAttribute('r', '5');
        }
    });
}

// ── BOOKING FORM ──
function submitBooking() {
    const firstName = document.getElementById('firstName').value.trim();
    const email = document.getElementById('email').value.trim();
    const tour = document.getElementById('tourSelect').value;
    if (!firstName || !email || !tour) {
        alert('Please fill in your name, email, and select a tour.');
        return;
    }
    if (cookiesAccepted) {
        setCookie(LAST_VIEWED_KEY, tour, 30);
        saveFormData();
    }
    document.getElementById('bookingFormInner').style.display = 'none';
    document.getElementById('formSuccess').classList.add('show');
}

// ── LANGUAGE TOGGLE ──
const translations = {
    en: {
        navTours: 'Tours', navDest: 'Destinations', navAbout: 'About',
        navBlog: 'Blog', navBook: 'Book', navCta: 'Book a tour',
        heroEye: "Macedonia's premier expedition company",
        heroTitle: "Where the <em>wild</em> mountains call your name",
        heroCta: 'Explore tours',
        heroCtaSecondary: 'Our story',
        subText: "Discover ancient lakes, hidden gorges, and centuries-old monasteries. We take you off the map — into the real Macedonia.",
        statFirst: "CURATED ROUTES",
        statSecond: "ADVENTURERS GUIDED",
        statThird: "REGIONS COVERED",
        tourFirst: "Our expeditions",
        tourSecond: "Choose your adventure",
        tourThird: "Handcrafted journeys for every pace — from easy cultural walks to multi-day wilderness treks.",
        tourFilterFirst: "All tours",
        tourFilterSecond: "Nature",
        tourFilterThird: "Cultural",
        tourFilterFourth: "Adventure",
        tourFilterFifth: "Winter",
        destFirst: "Where we go",
        destSecond: "Explore Macedonia's wonders",
        destThird: "From the shores of Ohrid Lake to the peaks of Mavrovo — every corner holds a story.",
        title: "North Macedonia",
    },
    mk: {
        navTours: 'Тури', navDest: 'Дестинации', navAbout: 'За нас',
        navBlog: 'Блог', navBook: 'Резервирај', navCta: 'Резервирај тура',
        heroEye: 'Водечка експедициска компанија во Македонија',
        heroTitle: "Каде <em>дивите</em> планини те повикуваат",
        heroCta: 'Истражи тури',
        heroCtaSecondary: 'Нашата приказна',
        subText: "Откријте древни езера, скриени клисури и вековни манастири. Ве носиме од мапата — во вистинската Македонија.",
        statFirst: "ОПФАТЕНИ РУТИ",
        statSecond: "НАПРАВЕНИ РУТИ",
        statThird: "ОПФАТЕНИ РЕГИОНИ",
        tourFirst: "Нашите експедиции",
        tourSecond: "Изберете ја вашата авантура",
        tourThird: "Рачно изработени патувања за секое темпо - од лесни културни прошетки до повеќедневни планинарења во дивината.",
        tourFilterFirst: "Сите тури",
        tourFilterSecond: "Природа",
        tourFilterThird: "Културни",
        tourFilterFourth: "Авантура",
        tourFilterFifth: "Зима",
        destFirst: "Каде одиме",
        destSecond: "Истражете ги чудата на Македонија",
        destThird: "Од бреговите на Охридското Езеро до врвовите на Маврово — секој агол крие приказна.",
        title: "Северна Македонија",
    }
};

const aboutEn = {
    first: "Who we are",
    second: "Born from the mountains, guided by passion",
    third: "Lynx Expeditions was founded in 2017 by a group of local guides who wanted to share Macedonia's hidden treasures with the world. Named after the critically endangered Balkan lynx — Macedonia's rarest and most elusive resident — we believe in travel that protects what it celebrates.",
    fourth: "Local expertise",
    fourthTemp: "Every guide is a local — born and raised in the regions they lead.",
    fifth: "Sustainable travel",
    fifthTemp: "5% of every booking goes to Macedonian wildlife conservation.",
    sixth: "Small groups only",
    sixthTemp: "Maximum 10 people per tour. More nature, fewer crowds.",
    seventh: "Meet the guides",
}
const firstGuideEn = [window.__LYNX_DATA__.guidesEn[0].name, window.__LYNX_DATA__.guidesEn[0].role]
const secondGuideEn = [window.__LYNX_DATA__.guidesEn[1].name, window.__LYNX_DATA__.guidesEn[1].role]
const thirdGuideEn = [window.__LYNX_DATA__.guidesEn[2].name, window.__LYNX_DATA__.guidesEn[2].role]
const fourthGuideEn = [window.__LYNX_DATA__.guidesEn[3].name, window.__LYNX_DATA__.guidesEn[3].role]

const aboutMk = {
    first: "Кои сме ние",
    second: "Родени во планините, водени од страста",
    third: "Lynx Expeditions е основана во 2017 година од група локални водичи кои сакаа да ги споделат скриените богатства на Македонија со светот. Именувани по критично загрозениот балкански рис — најреткиот и најтаинствениот жител на Македонија — ние веруваме во патувања кои го штитат она што го слават.",
    fourth: "Локална експертиза",
    fourthTemp: "Секој водич е локалец — роден и израснат во регионите што ги води.",
    fifth: "Одржливо патување",
    fifthTemp: "5% од секоја резервација одат за заштита на дивиот свет во Македонија.",
    sixth: "Само мали групи",
    sixthTemp: "Максимум 10 луѓе по тура. Повеќе природа, помалку метеж.",
    seventh: "Запознајте ги водичите",
}
const firstGuideMk = [window.__LYNX_DATA__.guidesMk[0].name, window.__LYNX_DATA__.guidesMk[0].role]
const secondGuideMk = [window.__LYNX_DATA__.guidesMk[1].name, window.__LYNX_DATA__.guidesMk[1].role]
const thirdGuideMk = [window.__LYNX_DATA__.guidesMk[2].name, window.__LYNX_DATA__.guidesMk[2].role]
const fourthGuideMk = [window.__LYNX_DATA__.guidesMk[3].name, window.__LYNX_DATA__.guidesMk[3].role]

const testimonialsEn = ['What travelers say', 'Real stories, real adventures', 'Over 1,200 guests have explored Macedonia with us. Here are some of their stories.']
const testimonialsMk = ['Што кажуваат туристите', 'Вистински приказни, вистински авантури', 'Преку 1,200 гости ја имаат истражувано Македонија со нас. Еве се некои од нивните приказни.']

const journalEn = ['Travel journal', 'Stories from the trail', 'Guides, tips, seasonal updates, and dispatches from the Macedonian wild.']
const journalMk = ['Патнички дневник', 'Приказни од патеката', 'Водичи, совети, сезонски новости и извештаи од македонската дивина.']

const submitLeftEn = ['Reserve your place','Ready to go?','Fill in your details and we\'ll confirm availability within 24 hours. All tours include a local guide, transport, and meals where noted.']
const submitLeftStepsEn = {
    0:['Submit your request','Tell us which tour and your preferred dates.'],
    1:['We confirm availability','Expect a reply within 24 hours with pricing and details.'],
    2:['Secure your spot','A 30% deposit holds your place. Full payment 14 days before departure.']}
const submitRightEn = ['First name','Last name','Email address','Phone number','Number of people','Select tour','Preferred start date','Flexibility','Special requests or questions','Dietary needs, accessibility requirements, questions about the tour...', 'Send booking request →', '🔒 Your information is safe. We never share your data with third parties.']
const chooseTourEn = ['Choose a tour...','Matka Canyon Boat & Cave Tour','Ohrid Lake Cultural Journey','Mavrovo Winter Ski Week','Stobi Ancient City Walk','Galicnik Village Escape','Prespa Lake Pelican Watch']
const selectSomethingEn = ['Select...','Exact date only','±3 days','±1 week','Flexible']

const submitLeftMk = ['Резервирајте го вашето место', 'Подготвени за тргнување?', 'Пополнете ги вашите податоци и ќе ја потврдиме достапноста во рок од 24 часа. Сите тури вклучуваат локален водич, транспорт и оброци каде што е наведено.']
const submitLeftStepsMk = {
    0: ['Поднесете го вашето барање', 'Кажете ни за која тура сте заинтересирани и вашите претпочитани датуми.'],
    1: ['Ние ја потврдуваме достапноста', 'Очекувајте одговор во рок од 24 часа со цени и дополнителни детали.'],
    2: ['Обезбедете го вашето место', 'Депозит од 30% го резервира вашето место. Целосна уплата 14 дена пред поаѓање.']}
const submitRightMk = ['Име', 'Презиме', 'Е-пошта', 'Телефонски број', 'Број на луѓе', 'Изберете тура', 'Претпочитан датум на започнување', 'Флексибилност', 'Посебни барања или прашања', 'Диетални потреби, барања за пристапност, прашања за турата...','Испрати барање за резервација →', '🔒 Вашите информации се безбедни. Никогаш не ги споделуваме вашите податоци со трети страни.']
const chooseTourMk = ['Изберете тура...', 'Тура со чамец и посета на пештера во кањонот Матка', 'Културно патување покрај Охридското Езеро', 'Зимска скијачка недела во Маврово', 'Прошетка низ античкиот град Стоби', 'Бегство во селото Галичник', 'Набљудување пеликани на Преспанското Езеро']
const selectSomethingMk = ['Изберете...', 'Само на точниот датум', '±3 дена', '±1 недела', 'Флексибилно']

const footerEn = 'Guiding adventurers through the wild beauty of North Macedonia since 2017. Small groups. Big experiences.'
const footerListHeadingEn = ['Nature tours', 'Destinations', 'Company']
const footerListEn = {
    0:['Nature tours','Cultural walks','Adventure treks','Winter expeditions','Custom tours'],
    1:['Ohrid','Matka Canyon','Mavrovo','Stobi','Prespa Lake'],
    2:['About us','Travel blog','Book a tour','Privacy policy','Cookie settings']
}

const footerMk = 'Водење на авантуристи низ дивата убавина на Северна Македонија од 2017 година. Мали групи. Големи искуства.'
const footerListHeadingMk = ['Природни тури', 'Дестинации', 'Компанија']
const footerListMk = {
    0: ['Природни тури', 'Културни прошетки', 'Авантуристички трекинзи', 'Зимски експедиции', 'Прилагодени тури'],
    1: ['Охрид', 'Кањон Матка', 'Маврово', 'Стоби', 'Преспанско Езеро'],
    2: ['За нас', 'Блог за патувања', 'Резервирај тура', 'Политика за приватност', 'Поставки за колачиња']
}

function toggleLang() {
    //First part of page

    currentLang = currentLang === 'en' ? 'mk' : 'en';
    const t = translations[currentLang];
    const btn = document.getElementById('langBtn');
    btn.textContent = currentLang === 'en' ? 'МК' : 'EN';
    document.querySelector('.hero-eyebrow').textContent = t.heroEye;
    document.querySelector('.hero-title').innerHTML = t.heroTitle;
    const heroBtns = document.querySelectorAll('.hero-btns a');
    const heroKeys = ['heroCta', 'heroCtaSecondary'];
    heroBtns.forEach((btn, i) => {
        if (heroKeys[i]) btn.textContent = t[heroKeys[i]];
    });
    const navLinks = document.querySelectorAll('.nav-links a');
    const keys = ['navTours', 'navDest', 'navAbout', 'navBlog', 'navBook'];
    navLinks.forEach((a, i) => {
        if (keys[i]) a.textContent = t[keys[i]];
    });
    document.querySelector('.nav-cta').textContent = t.navCta;
    document.querySelector('.hero-sub').textContent = t.subText;
    const stats = document.querySelectorAll('.hero-stats .hero-stat .hero-stat-label');
    const statsKeys = ['statFirst','statSecond', 'statThird'];
    stats.forEach((stat,index) => {
        if (statsKeys[index]) stat.textContent = t[statsKeys[index]];
    })

    //Second part of page
    document.querySelector('.tours-header .section-eyebrow').textContent = t.tourFirst;
    document.querySelector('.tours-header .section-title').textContent = t.tourSecond;
    document.querySelector('.tours-header .section-sub').textContent = t.tourThird;
    const tourButtons = document.querySelectorAll('.tours-section .tours-filter .filter-btn');
    const tourKeys = ['tourFilterFirst', 'tourFilterSecond', 'tourFilterThird', 'tourFilterFourth', 'tourFilterFifth']
    tourButtons.forEach((btn, i) => {
        if (tourKeys[i]) btn.textContent = t[tourKeys[i]];
    })
    renderTours()

    if (currentLang === 'en') {
        document.querySelector('#detailFooter #detailSaveBtn').textContent = '♡ Save'
        document.querySelector('#detailFooter #detailBookBtn').textContent = 'Book this tour →'
    } else {
        document.querySelector('#detailFooter #detailSaveBtn').textContent = '♡ Зачувај'
        document.querySelector('#detailFooter #detailBookBtn').textContent = 'Резервирај ја турата →'
    }

    //Third part of page
    document.querySelector('#destinations .section-eyebrow').textContent = t.destFirst;
    document.querySelector('#destinations .section-title').textContent = t.destSecond;
    document.querySelector('#destinations .section-sub').textContent = t.destThird;
    document.querySelector('#titleName').textContent = t.title;
    renderDestinations()

    //Fourth part of page
    var about = {}
    var firstGuide = {}
    var secondGuide = {}
    var thirdGuide = {}
    var fourthGuide = {}
    var testimonials = []
    var journal = []
    var submitLeft = []
    var submitLeftSteps = {}
    var submitRight = []
    var chooseTour = []
    var selectSomething = []
    var footer = ''
    var footerListHeading = []
    var footerList = {}

    if (currentLang === 'en') {
        about = aboutEn
        firstGuide = firstGuideEn
        secondGuide = secondGuideEn
        thirdGuide = thirdGuideEn
        fourthGuide = fourthGuideEn
        testimonials = testimonialsEn
        journal = journalEn
        submitLeft = submitLeftEn
        submitLeftSteps = submitLeftStepsEn
        submitRight = submitRightEn
        chooseTour = chooseTourEn
        selectSomething = selectSomethingEn
        footer = footerEn
        footerListHeading = footerListHeadingEn
        footerList = footerListEn
    } else {
        about = aboutMk
        firstGuide = firstGuideMk
        secondGuide = secondGuideMk
        thirdGuide = thirdGuideMk
        fourthGuide = fourthGuideMk
        testimonials = testimonialsMk
        journal = journalMk
        submitLeft = submitLeftMk
        submitLeftSteps = submitLeftStepsMk
        submitRight = submitRightMk
        chooseTour = chooseTourMk
        selectSomething = selectSomethingMk
        footer = footerMk
        footerListHeading = footerListHeadingMk
        footerList = footerListMk
    }
    document.querySelector('.about-section .about-grid .about-text .section-eyebrow').textContent = about.first
    document.querySelector('.about-section .about-grid .about-text .section-title').textContent = about.second
    document.querySelector('.about-section .about-grid .about-text .section-sub').textContent = about.third
    const features = document.querySelectorAll('.about-section .about-grid .about-text .about-features')
    const keysSecond = {0:['fourth','fourthTemp'], 1:['fifth', 'fifthTemp'], 2:['sixth','sixthTemp']};
    features.forEach((feature,index) => {
        const something = feature.querySelectorAll('.about-feature .about-feature-text')
        something.forEach((feature,i) => {
            feature.querySelector('h4').textContent = about[keysSecond[i][0]]
            feature.querySelector('p').textContent = about[keysSecond[i][1]]
        })
    })
    document.querySelector('#meet').textContent = about.seventh

    document.querySelectorAll('#firstGuide div')[1].textContent = firstGuide[0]
    document.querySelectorAll('#firstGuide div')[2].textContent = firstGuide[1]

    document.querySelectorAll('#secondGuide div')[1].textContent = secondGuide[0]
    document.querySelectorAll('#secondGuide div')[2].textContent = secondGuide[1]

    document.querySelectorAll('#thirdGuide div')[1].textContent = thirdGuide[0]
    document.querySelectorAll('#thirdGuide div')[2].textContent = thirdGuide[1]

    document.querySelectorAll('#fourthGuide div')[1].textContent = fourthGuide[0]
    document.querySelectorAll('#fourthGuide div')[2].textContent = fourthGuide[1]

    //Fifth part of page

    document.querySelector('.testimonials-section .section-eyebrow').textContent = testimonials[0]
    document.querySelector('.testimonials-section .section-title').textContent = testimonials[1]
    document.querySelector('.testimonials-section .section-sub').textContent = testimonials[2]

    //Sixth part of page

    document.querySelector('#blog .section-eyebrow').textContent = journal[0]
    document.querySelector('#blog .section-title').textContent = journal[1]
    document.querySelector('#blog .section-sub').textContent = journal[2]

    //Seventh part of page
    document.querySelector('#booking .booking-wrapper .booking-info .section-eyebrow').textContent = submitLeft[0]
    document.querySelector('#booking .booking-wrapper .booking-info .section-title').textContent = submitLeft[1]
    document.querySelector('#booking .booking-wrapper .booking-info .section-sub').textContent = submitLeft[2]

    var array = document.querySelectorAll('#booking .booking-wrapper .booking-info .booking-steps .booking-step')
    array.forEach((booking,index) => {
        booking.querySelector('.step-text h4').textContent = submitLeftSteps[index][0]
        booking.querySelector('.step-text p').textContent = submitLeftSteps[index][1]
    })

    var secondArray = document.querySelectorAll('#booking .booking-form #bookingFormInner .form-grid .form-group')
    secondArray.forEach((booking,index) => {
        booking.querySelector('label').textContent = submitRight[index]
        if (index === 4) {
            if (currentLang === 'en') {
                booking.querySelector('select')[0].textContent = 'Select...'
            } else {
                booking.querySelector('select')[0].textContent = 'Изберете...'
            }
        }
        if (index === 5) {
            var temp = booking.querySelectorAll('select option')
            temp.forEach((select,index) => {
                select.textContent = chooseTour[index]
            })
        }
        if (index === 7) {
            var tempSecond = booking.querySelectorAll('select option')
            tempSecond.forEach((select,index) => {
                select.textContent = selectSomething[index]
            })
        }
        if (index === 8) {
            booking.querySelector('textarea').placeholder = submitRight[index+1]
        }
    })

    document.querySelector('#bookingFormInner .form-submit').textContent = submitRight[10]
    document.querySelector('#bookingFormInner .form-privacy').textContent = submitRight[11]

    //Eighth part of page

    document.querySelector('.footer-grid .footer-brand p').textContent = footer

    var footerSomething = document.querySelectorAll('.footer-grid .footer-col')
    footerSomething.forEach((footer,index) => {
        footer.querySelector('h5').textContent = footerListHeading[index]
        var tempFooter = footer.querySelectorAll('ul li a')
        tempFooter.forEach((link,indexSecond) => {
            link.textContent = footerList[index][indexSecond]
        })
    })

}

// ── MOBILE MENU ──
function toggleMobileMenu() {
    const links = document.querySelector('.nav-links');
    if (!links.style.display || links.style.display === 'none') {
        links.style.display = 'flex';
        links.style.flexDirection = 'column';
        links.style.position = 'absolute';
        links.style.top = '72px';
        links.style.left = '0';
        links.style.right = '0';
        links.style.background = 'rgba(26,43,31,0.98)';
        links.style.padding = '1.5rem 5%';
        links.style.gap = '1.5rem';
    } else {
        links.style.display = 'none';
    }
}

// ── SCROLL ANIMATIONS ──
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting) e.target.classList.add('visible');
    });
}, {threshold: 0.1});

// ── INIT ──
document.addEventListener('DOMContentLoaded', () => {
    renderTours();
    renderDestinations();
    selectDest(0);
    initCookies();
    document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));
});
