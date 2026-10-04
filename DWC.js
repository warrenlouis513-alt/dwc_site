document.addEventListener("DOMContentLoaded", function () {

    /* =======================
       SECTION SWITCHING
    ======================== */

    const sections = [
        "homeSection",
        "aboutSection",
        "locationSection",
        "bibleSection",
        "eventsSection",
        "contactSection"
    ];

    function hideAllSections() {
        sections.forEach(id => {
            const section = document.getElementById(id);
            if (section) {
                section.classList.remove("active");
            }
        });
    }

    window.showSection = function (sectionId) {
        hideAllSections();

        const target = document.getElementById(sectionId);
        if (target) {
            target.classList.add("active");
            window.scrollTo({ top: 0, behavior: "smooth" });
        }
    };

    window.showHome = function () {
        hideAllSections();

        const home = document.getElementById("homeSection");
        if (home) {
            home.classList.add("active");
            window.scrollTo({ top: 0, behavior: "smooth" });
        }
    };

    // Show Home on page load
    showHome();



    /* =======================
       BIBLE SECTION
    ======================== */

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

    const bookSelect = document.getElementById("bookSelect");
    const chapterSelect = document.getElementById("chapterSelect");
    const bibleDisplay = document.getElementById("bibleDisplay");
    const searchBtn = document.getElementById("searchBtn");
    const searchVerse = document.getElementById("searchVerse");

    if (bookSelect && chapterSelect && bibleDisplay) {

        // Clear before populating (important if page reloads)
        bookSelect.innerHTML = "";
        chapterSelect.innerHTML = "";

        // Add default options
        bookSelect.innerHTML = `<option value="">Select Book</option>`;
        chapterSelect.innerHTML = `<option value="">Chapter</option>`;

        // Populate books
        books.forEach(book => {
            const option = document.createElement("option");
            option.value = book;
            option.textContent = book;
            bookSelect.appendChild(option);
        });

        // Populate chapters (1–50 safe default)
        for (let i = 1; i <= 50; i++) {
            const option = document.createElement("option");
            option.value = i;
            option.textContent = i;
            chapterSelect.appendChild(option);
        }

        async function loadChapter(book, chapter) {
            if (!book || !chapter) return;

            bibleDisplay.innerHTML = "Loading...";

            try {
                const response = await fetch(`https://bible-api.com/${book}%20${chapter}`);
                const data = await response.json();

                if (data.text) {
                    bibleDisplay.innerHTML = data.text;
                } else {
                    bibleDisplay.innerHTML = "Chapter not found.";
                }

            } catch (error) {
                console.error(error);
                bibleDisplay.innerHTML = "Error loading scripture.";
            }
        }

        // Dropdown change events
        bookSelect.addEventListener("change", () => {
            loadChapter(bookSelect.value, chapterSelect.value);
        });

        chapterSelect.addEventListener("change", () => {
            loadChapter(bookSelect.value, chapterSelect.value);
        });

        // Search verse (John 3:16 format)
        if (searchBtn && searchVerse) {
            searchBtn.addEventListener("click", async () => {

                const query = searchVerse.value.trim();
                if (!query) return;

                bibleDisplay.innerHTML = "Loading...";

                try {
                    const response = await fetch(`https://bible-api.com/${encodeURIComponent(query)}`);
                    const data = await response.json();

                    if (data.text) {
                        bibleDisplay.innerHTML = data.text;
                    } else {
                        bibleDisplay.innerHTML = "Verse not found.";
                    }

                } catch (error) {
                    bibleDisplay.innerHTML = "Invalid verse format.";
                }

            });
        }
    }



    /* =======================
       ADMIN STYLE ENHANCEMENT
    ======================== */

    // Simple confirmation for admin delete buttons (if present)
    document.querySelectorAll(".delete-btn").forEach(btn => {
        btn.addEventListener("click", function (e) {
            if (!confirm("Are you sure you want to delete this item?")) {
                e.preventDefault();
            }
        });
    });

});