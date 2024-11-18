// Dummy data for demonstration purposes
const users = [
    { id: 1, name: 'Mr. Pierre Van-Hols', role: 'Broker' },
    { id: 2, name: 'Mr. Emilio Banzoni', role: 'Agent' },
    { id: 3, name: 'Mrs. Catherine Lee', role: 'Broker' }
];

function displayUsers() {
    const userList = document.getElementById('user-list');
    users.forEach(user => {
        const userCard = document.createElement('div');
        userCard.className = 'user-card';
        userCard.innerHTML = `
            <p><strong>Name:</strong> ${user.name}</p>
            <p><strong>Role:</strong> ${user.role}</p>
        `;
        userList.appendChild(userCard);
    });
}

document.addEventListener('DOMContentLoaded', displayUsers);
