function showUpdateFormUser(userId, name, email, role) {
  document.getElementById("updateUserForm").style.display = "block";
  document.getElementById("updateUserId").value = userId;
  document.getElementById("updateUserName").value = name;
  document.getElementById("updateUserEmail").value = email;
  document.getElementById("updateUserRole").value = role;
}

function showUpdateFormEvent(eventId, title, date) {
  document.getElementById("updateEventForm").style.display = "block";
  document.getElementById("updateEventId").value = eventId;
  document.getElementById("updateEventTitle").value = title;
  document.getElementById("updateEventDate").value = date;
}

function deleteUser(userId) {
  const confirmation = confirm("Are you sure you want to delete this user?");
  if (confirmation) {
    const formData = new FormData();
    formData.append("action", "delete_user");
    formData.append("id", userId);

    const csrfToken = document
      .querySelector('meta[name="csrf-token"]')
      .getAttribute("content");
    if (csrfToken) {
      formData.append("csrf_token", csrfToken);
    }

    fetch("admin-dashboard.php", {
      method: "POST",
      body: formData,
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
    })
      .then((response) => {
        if (response.ok) {
          return response.json();
        }
        throw new Error("Network response was not ok.");
      })
      .then((data) => {
        if (data.success) {
          alert("User deleted successfully!");
          document.getElementById("user_" + userId).remove();
        } else {
          alert("Error deleting user: " + (data.message || "Unknown error"));
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("An error occurred. Please try again.");
      });
  }
}

function loadSectionData(section) {
  fetch(`admin-dashboard.php?action=get_${section}`)
    .then((response) => response.json())
    .then((data) => {
      updateUI(section, data);
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("An error occurred while loading data. Please try again.");
    });
}

function updateUI(section, data) {
  const contentDiv = document.querySelector(".admin-content");
  let html = "";

  switch (section) {
    case "dashboard":
      html = generateDashboardHTML(data);
      break;
    case "users":
      html = generateUsersHTML(data);
      break;
    case "events":
      html = generateEventsHTML(data);
      break;
    case "categories":
      html = generateCategoriesHTML(data);
      break;
    case "tickets":
      html = generateTicketsHTML(data);
      break;
    default:
      html = "<p>Section not found</p>";
      break;
  }

  contentDiv.innerHTML = html;
}

function showModal(modalId) {
  document.getElementById(modalId).style.display = "block";
}

function hideModal(modalId) {
  document.getElementById(modalId).style.display = "none";
}

function generateDashboardHTML(data) {
  return `
          <h2>Dashboard Overview</h2>
          <div class="admin-stats">
              <div class="stat-card">
                  <h3>Total Users</h3>
                  <p class="stat-number">${data.users_count}</p>
              </div>
              <div class="stat-card">
                  <h3>Active Events</h3>
                  <p class="stat-number">${data.events_count}</p>
              </div>
              <div class="stat-card">
                  <h3>Categories</h3>
                  <p class="stat-number">${data.categories_count}</p>
              </div>
              <div class="stat-card">
                  <h3>Tickets Sold</h3>
                  <p class="stat-number">${data.tickets_count}</p>
              </div>
          </div>
      `;
}

function generateUsersHTML(users) {
  return `
          <h2>User Management</h2>
          <button class="admin-btn" onclick="showModal('add-user')">Add New User</button>
          <table class="admin-table">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th>Actions</th>
                  </tr>
              </thead>
              <tbody>
                  ${users
                    .map(
                      (user) => `
                      <tr id="user_${user.id}">
                          <td>${user.id}</td>
                          <td>${user.name}</td>
                          <td>${user.email}</td>
                          <td>${user.role}</td>
                          <td>
                              <button onclick="showUpdateFormUser(${user.id}, '${user.name}', '${user.email}', '${user.role}')">Edit</button>
                              <button onclick="deleteUser(${user.id})">Delete</button>
                          </td>
                      </tr>
                  `
                    )
                    .join("")}
              </tbody>
          </table>
      `;
}

function generateEventsHTML(events) {
  return `
          <h2>Events Management</h2>
          <button class="admin-btn" onclick="showModal('add-event')">Add New Event</button>
          <table class="admin-table">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Title</th>
                      <th>Date</th>
                      <th>Location</th>
                      <th>Actions</th>
                  </tr>
              </thead>
              <tbody>
                  ${events
                    .map(
                      (event) => `
                      <tr id="event_${event.id}">
                          <td>${event.id}</td>
                          <td>${event.title}</td>
                          <td>${event.event_date}</td>
                          <td>${event.location}</td>
                          <td>
                              <button onclick="showUpdateFormEvent(${event.id}, '${event.title}', '${event.event_date}')">Edit</button>
                              <button onclick="deleteEvent(${event.id})">Delete</button>
                          </td>
                      </tr>
                  `
                    )
                    .join("")}
              </tbody>
          </table>
      `;
}

function generateCategoriesHTML(categories) {
  return `
          <h2>Categories Management</h2>
          <button class="admin-btn" onclick="showModal('add-category')">Add New Category</button>
          <table class="admin-table">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Description</th>
                      <th>Actions</th>
                  </tr>
              </thead>
              <tbody>
                  ${categories
                    .map(
                      (category) => `
                      <tr id="category_${category.id}">
                          <td>${category.id}</td>
                          <td>${category.name}</td>
                          <td>${category.description}</td>
                          <td>
                              <button onclick="showUpdateFormCategory(${category.id}, '${category.name}', '${category.description}')">Edit</button>
                              <button onclick="deleteCategory(${category.id})">Delete</button>
                          </td>
                      </tr>
                  `
                    )
                    .join("")}
              </tbody>
          </table>
      `;
}

function generateTicketsHTML(tickets) {
  return `
          <h2>Tickets Management</h2>
          <button class="admin-btn" onclick="showModal('add-ticket')">Add New Ticket</button>
          <table class="admin-table">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>User</th>
                      <th>Event</th>
                      <th>Type</th>
                      <th>Price</th>
                      <th>Actions</th>
                  </tr>
              </thead>
              <tbody>
                  ${tickets
                    .map(
                      (ticket) => `
                      <tr id="ticket_${ticket.id}">
                          <td>${ticket.id}</td>
                          <td>${ticket.user_name}</td>
                          <td>${ticket.event_title}</td>
                          <td>${ticket.ticket_type}</td>
                          <td>${ticket.price}</td>
                          <td>
                              <button onclick="showUpdateFormTicket(${ticket.id}, '${ticket.user_id}', '${ticket.event_id}', '${ticket.ticket_type}', '${ticket.price}')">Edit</button>
                              <button onclick="deleteTicket(${ticket.id})">Delete</button>
                          </td>
                      </tr>
                  `
                    )
                    .join("")}
              </tbody>
          </table>
      `;
}

function getCsrfToken() {
  const tokenInput = document.querySelector('input[name="csrf_token"]');
  return tokenInput ? tokenInput.value : null;
}

document.addEventListener("DOMContentLoaded", () => {
  loadSectionData("dashboard");

  document.querySelectorAll(".admin-nav li").forEach((item) => {
    item.addEventListener("click", function () {
      const section = this.getAttribute("data-section");
      loadSectionData(section);
    });
  });

  const forms = document.querySelectorAll("form");
  forms.forEach((form) => {
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      const formData = new FormData(this);
      const action = formData.get("action");

      fetch("admin-dashboard.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            alert("Operation successful");
            hideModal(this.closest(".modal").id);
            loadSectionData(action.split("_")[1] + "s");
          } else {
            alert("Error: " + (data.message || "Unknown error"));
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          alert("An error occurred. Please try again.");
        });
    });
  });

  window.onclick = (event) => {
    if (event.target.classList.contains("modal")) {
      event.target.style.display = "none";
    }
  };

  document.querySelectorAll(".close").forEach((closeBtn) => {
    closeBtn.onclick = function () {
      this.closest(".modal").style.display = "none";
    };
  });
});
