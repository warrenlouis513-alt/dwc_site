// ==================== SECTIONS ====================
const sections = ['aboutSection', 'locationSection', 'bibleSection', 'eventsSection', 'contactSection'];

// Show any section
function showSection(sectionId) {
    document.getElementById("homeSection").style.display = "none";
    sections.forEach(id => {
        document.getElementById(id).style.display = 'none';
    });
    document.getElementById(sectionId).style.display = "block";

    // Refresh events if showing events
    if (sectionId === 'eventsSection') displayEvents();
}

// Show Home
function showHome() {
    document.getElementById("homeSection").style.display = "block";
    sections.forEach(id => {
        document.getElementById(id).style.display = 'none';
    });
}

// ==================== BIBLE SECTION ====================
const books = [
    "Genesis","Exodus","Leviticus","Numbers","Deuteronomy","Joshua","Judges","Ruth",
    "1 Samuel","2 Samuel","1 Kings","2 Kings","1 Chronicles","2 Chronicles","Ezra",
    "Nehemiah","Esther","Job","Psalms","Proverbs","Ecclesiastes","Song of Solomon",
    "Isaiah","Jeremiah","Lamentations","Ezekiel","Daniel","Hosea","Joel","Amos",
    "Obadiah","Jonah","Micah","Nahum","Habakkuk","Zephaniah","Haggai","Zechariah",
    "Malachi","Matthew","Mark","Luke","John","Acts","Romans","1 Corinthians","2 Corinthians",
    "Galatians","Ephesians","Philippians","Colossians","1 Thessalonians","2 Thessalonians",
    "1 Timothy","2 Timothy","Titus","Philemon","Hebrews","James","1 Peter","2 Peter",
    "1 John","2 John","3 John","Jude","Revelation"
];

const bookSelect = document.getElementById('bookSelect');
books.forEach(book => {
    const option = document.createElement('option');
    option.value = book;
    option.textContent = book;
    bookSelect.appendChild(option);
});

const chapterSelect = document.getElementById('chapterSelect');
for (let i = 1; i <= 50; i++) {
    const opt = document.createElement('option');
    opt.value = i;
    opt.textContent = i;
    chapterSelect.appendChild(opt);
}

async function loadVerse(book, chapter) {
    const display = document.getElementById('bibleDisplay');
    display.innerHTML = 'Loading...';
    try {
        const response = await fetch(`https://bible-api.com/${book} ${chapter}`);
        const data = await response.json();
        display.innerHTML = data.text || 'Verse not found.';
    } catch(err) {
        display.innerHTML = 'Error fetching verse.';
        console.error(err);
    }
}

bookSelect.addEventListener('change', () => loadVerse(bookSelect.value, chapterSelect.value));
chapterSelect.addEventListener('change', () => loadVerse(bookSelect.value, chapterSelect.value));

document.getElementById('searchBtn').addEventListener('click', () => {
    const query = document.getElementById('searchVerse').value.trim();
    if (!query) return;

    const [book, chapterVerse] = query.split(' ', 2);
    loadVerse(book, chapterVerse);
});

// ==================== EVENTS SECTION ====================
let events = [];

function displayEvents() {
    const container = document.getElementById('eventsList');
    container.innerHTML = '';

    if(events.length === 0) {
        container.innerHTML = '<p>No upcoming events yet.</p>';
        return;
    }

    // Sort events by date
    events.sort((a,b) => new Date(a.date) - new Date(b.date));

    events.forEach(event => {
        const div = document.createElement('div');
        div.classList.add('eventItem');
        div.innerHTML = `
            <p><strong>Date:</strong> ${event.date}</p>
            <p><strong>Event:</strong> ${event.name}</p>
            <p><strong>Location:</strong> ${event.location}</p>
            ${event.description ? `<p><strong>Description:</strong> ${event.description}</p>` : ''}
            <hr>
        `;
        container.appendChild(div);
    });
}

const eventsForm = document.getElementById('eventsForm');
if(eventsForm){
    eventsForm.addEventListener('submit', function(e){
        e.preventDefault();

        const name = document.getElementById('eventName').value;
        const date = document.getElementById('eventDate').value;
        const location = document.getElementById('eventLocation').value;
        const description = document.getElementById('eventDescription').value;

        events.push({ name, date, location, description });

        this.reset();
        displayEvents();
    });
}

// ==================== CONTACT SECTION ====================
let messages = [];

const contactForm = document.getElementById('contactForm');
if (contactForm) {
    contactForm.addEventListener('submit', function(e){
        e.preventDefault();

        const name = document.getElementById('contactName').value;
        const email = document.getElementById('contactEmail').value;
        const message = document.getElementById('contactMessage').value;

        messages.push({ name, email, message });

        this.reset();
        displayMessages();
    });
}

function displayMessages() {
    const container = document.getElementById('contactMessages');
    container.innerHTML = '';

    if(messages.length === 0){
        container.innerHTML = '<p>No messages yet.</p>';
        return;
    }

    messages.forEach(msg => {
        const div = document.createElement('div');
        div.style.borderBottom = "1px solid #4B0082";
        div.style.marginBottom = "10px";
        div.innerHTML = `
            <p><strong>Name:</strong> ${msg.name}</p>
            <p><strong>Email:</strong> ${msg.email}</p>
            <p><strong>Message:</strong> ${msg.message}</p>
        `;
        container.appendChild(div);
    });
}