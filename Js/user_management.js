(() => {
    "use strict";

    // Defining our API Endpoints
    const API_ENDPOINTS = {
        CREATE: "../actions/create_user.php",
        UPDATE: "../actions/update_user.php",
        DELETE: "../actions/delete_user.php",
    };

    /**
     * Helper Functions
     */

    // Sanitize HTML to prevent injection attacks
    const sanitizeHTML = (str) => {
        const tempDiv = document.createElement("div");
        tempDiv.textContent = str;
        return tempDiv.innerHTML;
    };

    // Send AJAX requests
    const sendRequest = async (url, method, data = {}) => {
        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            return await response.json();
        } catch (error) {
            console.error("Request failed:", error);
            return { status: "error", message: error.message };
        }
    };

    /**
     * CRUD Operations
     */

    // Add User
    const addUser = async (event) => {
        event.preventDefault();

        const formData = new FormData(event.target);
        const data = Object.fromEntries(formData.entries());

        const result = await sendRequest(API_ENDPOINTS.CREATE, "POST", data);
        if (result.status === "success") {
            alert("User added successfully!");
            location.reload();
        } else {
            alert(`Error: ${result.message}`);
        }
    };

    // Edit User
    const editUser = async (id) => {
        const userRow = document.getElementById(`user-${id}`);
        const fname = userRow.querySelector(".fname").textContent.trim();
        const lname = userRow.querySelector(".lname").textContent.trim();
        const role = userRow.querySelector(".role").textContent.trim() === "Super Admin" ? "1" : "2";

        const newFname = prompt("Enter first name:", fname);
        const newLname = prompt("Enter last name:", lname);
        const newRole = prompt("Enter role (1 for Super Admin, 2 for Admin):", role);

        if (newFname && newLname && newRole) {
            const result = await sendRequest(API_ENDPOINTS.UPDATE, "POST", {
                id,
                fname: newFname,
                lname: newLname,
                role: newRole,
            });

            if (result.status === "success") {
                alert("User updated successfully!");
                location.reload();
            } else {
                alert(`Error: ${result.message}`);
            }
        }
    };

    // Delete User
    const deleteUser = async (id) => {
        if (confirm("Are you sure you want to delete this user?")) {
            const result = await sendRequest(API_ENDPOINTS.DELETE, "POST", { id });
            if (result.status === "success") {
                alert("User deleted successfully!");
                document.getElementById(`user-${id}`).remove();
            } else {
                alert(`Error: ${result.message}`);
            }
        }
    };

    /**
     * User Display
     */

    const displayUsers = (users) => {
        const userList = document.getElementById("user-list");

        if (!userList) {
            console.error("User list container not found!");
            return;
        }

        userList.innerHTML = ""; // Clear any existing content

        users.forEach((user) => {
            const userRow = document.createElement("tr");
            userRow.id = `user-${user.id}`;
            userRow.innerHTML = `
                <td class="fname">${sanitizeHTML(user.fname)}</td>
                <td class="lname">${sanitizeHTML(user.lname)}</td>
                <td class="email">${sanitizeHTML(user.email)}</td>
                <td class="role">${sanitizeHTML(user.userrole === "1" ? "Super Admin" : "Admin")}</td>
                <td class="created_at">${sanitizeHTML(user.created_at)}</td>
                <td>
                    <button onclick="editUser(${user.id})">Edit</button>
                    <button onclick="deleteUser(${user.id})">Delete</button>
                </td>
            `;
            userList.appendChild(userRow);
        });
    };

    /**
     * Event Listeners
     */

    // Initialize the script
    document.addEventListener("DOMContentLoaded", () => {
        // Attach form submission listener
        const addUserForm = document.getElementById("add-user-form");
        if (addUserForm) {
            addUserForm.addEventListener("submit", addUser);
        }

        // Fetch and display users (for demonstration, use dummy data)
        const users = [
            { id: 1, fname: "Antoine", lname: "Karis", userrole: "2", email: "antoine@example.com", created_at: "2024-11-20" },
            { id: 2, fname: "Yasmine", lname: "Franklin", userrole: "2", email: "yasmine@example.com", created_at: "2024-11-21" },
        ];
        displayUsers(users);
    });

    // Expose globally for inline buttons
    window.editUser = editUser;
    window.deleteUser = deleteUser;
})();
