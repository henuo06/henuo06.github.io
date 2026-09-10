document.addEventListener("DOMContentLoaded", () => {
  // Footer year
  const yearEl = document.getElementById("year");
  if (yearEl) yearEl.textContent = new Date().getFullYear();

  // Status indicator
  const statusText = document.getElementById("statusText");
  if (statusText) statusText.textContent = "Online ✅";

  // Mobile nav toggle
  const toggle = document.getElementById("navToggle");
  const links = document.getElementById("navLinks");

  if (toggle && links) {
    toggle.addEventListener("click", () => {
      const open = links.classList.toggle("is-open");
      toggle.setAttribute("aria-expanded", String(open));
    });
  }

  // Contact form (front-end placeholder)
  const form = document.getElementById("contactForm");
  const note = document.getElementById("formNote");

  if (form && note) {
    form.addEventListener("submit", (e) => {
      e.preventDefault();
      note.textContent = "Thanks — message sending is not wired up yet. (Next step: PHP mail handler.)";
      form.reset();
    });
  }

  // Logged-in UI: replace Login with Account dropdown
  fetch("/auth-check.php")
    .then((r) => r.json())
    .then((data) => {
      if (!data || !data.loggedIn) return;

      // Swap nav login slot -> account menu
      const slot = document.getElementById("accountSlot");
      const menu = document.getElementById("accountMenu");
      if (slot && menu) {
        slot.replaceWith(menu);
        menu.hidden = false;

        const btn = document.getElementById("accountBtn");
        const dropdown = document.getElementById("accountDropdown");

        if (btn && dropdown) {
          btn.addEventListener("click", () => {
            const open = dropdown.style.display === "block";
            dropdown.style.display = open ? "none" : "block";
            btn.setAttribute("aria-expanded", String(!open));
          });

          // Close on outside click
          document.addEventListener("click", (e) => {
            if (!menu.contains(e.target)) {
              dropdown.style.display = "none";
              btn.setAttribute("aria-expanded", "false");
            }
          });
        }
      }

      // Also update hero + footer login links to point to account management
      const heroLogin = document.getElementById("heroLoginLink");
      if (heroLogin) {
        heroLogin.textContent = "Account";
        heroLogin.href = "/dashboard.php";
      }

      const footerLogin = document.getElementById("footerLoginLink");
      if (footerLogin) {
        footerLogin.textContent = "Account";
        footerLogin.href = "/dashboard.php";
      }
    })
    .catch(() => {});
});
