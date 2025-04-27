// taskManager.js

// State management
let currentGroups = [];
let selectedGroupId = null;
let editingTaskId = null;
let editingGroupId = null;

// API endpoints
const API_BASE_URL = '/api';
const ENDPOINTS = {
    GROUPS: `${API_BASE_URL}/task-groups`,
    TASKS: `${API_BASE_URL}/tasks`
};

// DOM Elements
const groupList = document.getElementById('groupList');
const taskList = document.getElementById('taskList');
const noGroupSelected = document.getElementById('noGroupSelected');
const groupDetails = document.getElementById('groupDetails');
const groupName = document.getElementById('groupName');
const vendorType = document.getElementById('vendorType');

// Buttons
const addGroupBtn = document.getElementById('addGroupBtn');
const editGroupBtn = document.getElementById('editGroupBtn');
const deleteGroupBtn = document.getElementById('deleteGroupBtn');
const addTaskBtn = document.getElementById('addTaskBtn');

// Modals
const groupModal = document.getElementById('groupModal');
const taskModal = document.getElementById('taskModal');
const confirmationModal = document.getElementById('confirmationModal');
const groupModalTitle = document.getElementById('groupModalTitle');
const taskModalTitle = document.getElementById('taskModalTitle');
const confirmationMessage = document.getElementById('confirmationMessage');
const confirmBtn = document.getElementById('confirmBtn');

// Forms
const groupForm = document.getElementById('groupForm');
const taskForm = document.getElementById('taskForm');
const groupNameInput = document.getElementById('groupNameInput');
const vendorTypeSelect = document.getElementById('vendorTypeSelect');
const taskNameInput = document.getElementById('taskNameInput');
const taskDescriptionInput = document.getElementById('taskDescriptionInput');
const taskDaysInput = document.getElementById('taskDaysInput');

// Event Listeners
document.addEventListener('DOMContentLoaded', initialize);
addGroupBtn.addEventListener('click', showAddGroupModal);
editGroupBtn.addEventListener('click', showEditGroupModal);
deleteGroupBtn.addEventListener('click', confirmDeleteGroup);
addTaskBtn.addEventListener('click', showAddTaskModal);

groupForm.addEventListener('submit', handleGroupSubmit);
taskForm.addEventListener('submit', handleTaskSubmit);

// Close modals
document.querySelectorAll('.close-modal, .cancel-btn').forEach(element => {
    element.addEventListener('click', closeAllModals);
});

// Helper Functions
function initialize() {
    fetchGroups();
}

async function fetchGroups() {
    try {
        const response = await fetch(ENDPOINTS.GROUPS, {
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${localStorage.getItem("authToken")}`,
            },
        });
        
        if (!response.ok) {
            throw new Error('Failed to fetch groups');
        }
        
        currentGroups = await response.json();
        renderGroupList();
        
        if (selectedGroupId) {
            const group = currentGroups.find(g => g.id === selectedGroupId);
            if (group) {
                selectGroup(group);
            } else {
                selectedGroupId = null;
                showNoGroupSelected();
            }
        } else {
            showNoGroupSelected();
        }
    } catch (error) {
        console.error('Error fetching groups:', error);
        showNotification('Failed to load task groups', 'error');
    }
}

async function fetchTasks(groupId) {
    try {
        const response = await fetch(`${ENDPOINTS.GROUPS}/${groupId}/tasks`, {
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${localStorage.getItem("authToken")}`,
            },
        });
        
        if (!response.ok) {
            throw new Error('Failed to fetch tasks');
        }
        
        const tasks = await response.json();
        return tasks;
    } catch (error) {
        console.error('Error fetching tasks:', error);
        showNotification('Failed to load tasks', 'error');
        return [];
    }
}

function renderGroupList() {
    groupList.innerHTML = '';
    
    if (currentGroups.length === 0) {
        groupList.innerHTML = '<li class="empty-message">No task groups found</li>';
        return;
    }
    
    currentGroups.forEach(group => {
        const groupElement = document.createElement('li');
        groupElement.classList.add('group-item');
        if (selectedGroupId === group.id) {
            groupElement.classList.add('active');
        }
        
        groupElement.innerHTML = `
            <div class="group-item-header">
                <h3 class="group-item-title">${group.name}</h3>
            </div>
            <div class="group-item-type">${group.typeID}</div>
        `;
        
        groupElement.addEventListener('click', () => selectGroup(group));
        groupList.appendChild(groupElement);
    });
}

async function selectGroup(group) {
    selectedGroupId = group.id;
    renderGroupList();
    
    // Update group details
    groupName.textContent = group.name;
    vendorType.textContent = group.typeID;
    
    // Show group details section
    noGroupSelected.classList.add('hidden');
    groupDetails.classList.remove('hidden');
    
    // Fetch and render tasks
    const tasks = await fetchTasks(group.id);
    renderTaskList(tasks);
}

function renderTaskList(tasks) {
    taskList.innerHTML = '';
    
    if (tasks.length === 0) {
        taskList.innerHTML = '<li class="empty-message">No tasks found</li>';
        return;
    }
    
    tasks.forEach(task => {
        const taskElement = document.createElement('li');
        taskElement.classList.add('task-item');
        taskElement.dataset.id = task.id;
        
        taskElement.innerHTML = `
            <div class="task-item-header">
                <h4 class="task-item-name">${task.name}</h4>
                <span class="task-item-days">${task.daysToComplete} days</span>
                <div class="task-actions">
                    <button type="button" class="edit-task-btn" aria-label="Edit task">
                        <svg class="edit-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                        </svg>
                    </button>
                    <button type="button" class="delete-task-btn" aria-label="Delete task">
                        <svg class="delete-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <p class="task-item-description">${task.description}</p>
        `;
        
        taskElement.querySelector('.edit-task-btn').addEventListener('click', () => {
            showEditTaskModal(task);
        });
        
        taskElement.querySelector('.delete-task-btn').addEventListener('click', () => {
            confirmDeleteTask(task);
        });
        
        taskList.appendChild(taskElement);
    });
}

function showNoGroupSelected() {
    noGroupSelected.classList.remove('hidden');
    groupDetails.classList.add('hidden');
}

// Group Operations
function showAddGroupModal() {
    groupModalTitle.textContent = 'Create Task Group';
    groupNameInput.value = '';
    vendorTypeSelect.value = '';
    editingGroupId = null;
    groupModal.classList.remove('hidden');
}

function showEditGroupModal() {
    if (!selectedGroupId) return;
    
    const group = currentGroups.find(g => g.id === selectedGroupId);
    if (!group) return;
    
    groupModalTitle.textContent = 'Edit Task Group';
    groupNameInput.value = group.name;
    vendorTypeSelect.value = group.typeID;
    editingGroupId = group.id;
    groupModal.classList.remove('hidden');
}

async function handleGroupSubmit(event) {
    event.preventDefault();
    
    const groupData = {
        name: groupNameInput.value.trim(),
        typeID: vendorTypeSelect.value
    };
    
    if (editingGroupId) {
        // Update existing group
        await updateGroup(editingGroupId, groupData);
    } else {
        // Create new group
        await createGroup(groupData);
    }
    
    closeAllModals();
}

async function createGroup(groupData) {
    try {
        const response = await fetch(ENDPOINTS.GROUPS, {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${localStorage.getItem("authToken")}`,
            },
            body: JSON.stringify(groupData)
        });
        
        if (!response.ok) {
            throw new Error('Failed to create group');
        }
        
        showNotification('Task group created successfully', 'success');
        fetchGroups();
    } catch (error) {
        console.error('Error creating group:', error);
        showNotification('Failed to create task group', 'error');
    }
}

async function updateGroup(groupId, groupData) {
    try {
        const response = await fetch(`${ENDPOINTS.GROUPS}/${groupId}`, {
            method: 'PUT',
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${localStorage.getItem("authToken")}`,
            },
            body: JSON.stringify(groupData)
        });
        
        if (!response.ok) {
            throw new Error('Failed to update group');
        }
        
        showNotification('Task group updated successfully', 'success');
        fetchGroups();
    } catch (error) {
        console.error('Error updating group:', error);
        showNotification('Failed to update task group', 'error');
    }
}

function confirmDeleteGroup() {
    if (!selectedGroupId) return;
    
    const group = currentGroups.find(g => g.id === selectedGroupId);
    if (!group) return;
    
    confirmationMessage.textContent = `Are you sure you want to delete the task group "${group.name}"? This will also delete all tasks in this group.`;
    
    confirmBtn.onclick = async () => {
        await deleteGroup(selectedGroupId);
        closeAllModals();
    };
    
    confirmationModal.classList.remove('hidden');
}

async function deleteGroup(groupId) {
    try {
        const response = await fetch(`${ENDPOINTS.GROUPS}/${groupId}`, {
            method: 'DELETE',
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${localStorage.getItem("authToken")}`,
            }
        });
        
        if (!response.ok) {
            throw new Error('Failed to delete group');
        }
        
        selectedGroupId = null;
        showNotification('Task group deleted successfully', 'success');
        fetchGroups();
    } catch (error) {
        console.error('Error deleting group:', error);
        showNotification('Failed to delete task group', 'error');
    }
}

// Task Operations
function showAddTaskModal() {
    if (!selectedGroupId) return;
    
    taskModalTitle.textContent = 'Add Task';
    taskNameInput.value = '';
    taskDescriptionInput.value = '';
    taskDaysInput.value = '';
    editingTaskId = null;
    taskModal.classList.remove('hidden');
}

function showEditTaskModal(task) {
    taskModalTitle.textContent = 'Edit Task';
    taskNameInput.value = task.name;
    taskDescriptionInput.value = task.description;
    taskDaysInput.value = task.daysToComplete;
    editingTaskId = task.id;
    taskModal.classList.remove('hidden');
}

async function handleTaskSubmit(event) {
    event.preventDefault();
    
    const taskData = {
        name: taskNameInput.value.trim(),
        description: taskDescriptionInput.value.trim(),
        daysToComplete: parseInt(taskDaysInput.value, 10),
        groupId: selectedGroupId
    };
    
    if (editingTaskId) {
        // Update existing task
        await updateTask(editingTaskId, taskData);
    } else {
        // Create new task
        await createTask(taskData);
    }
    
    closeAllModals();
}

async function createTask(taskData) {
    try {
        const response = await fetch(`${ENDPOINTS.GROUPS}/${selectedGroupId}/tasks`, {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${localStorage.getItem("authToken")}`,
            },
            body: JSON.stringify(taskData)
        });
        
        if (!response.ok) {
            throw new Error('Failed to create task');
        }
        
        showNotification('Task created successfully', 'success');
        const tasks = await fetchTasks(selectedGroupId);
        renderTaskList(tasks);
    } catch (error) {
        console.error('Error creating task:', error);
        showNotification('Failed to create task', 'error');
    }
}

async function updateTask(taskId, taskData) {
    try {
        const response = await fetch(`${ENDPOINTS.TASKS}/${taskId}`, {
            method: 'PUT',
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${localStorage.getItem("authToken")}`,
            },
            body: JSON.stringify(taskData)
        });
        
        if (!response.ok) {
            throw new Error('Failed to update task');
        }
        
        showNotification('Task updated successfully', 'success');
        const tasks = await fetchTasks(selectedGroupId);
        renderTaskList(tasks);
    } catch (error) {
        console.error('Error updating task:', error);
        showNotification('Failed to update task', 'error');
    }
}

function confirmDeleteTask(task) {
    confirmationMessage.textContent = `Are you sure you want to delete the task "${task.name}"?`;
    
    confirmBtn.onclick = async () => {
        await deleteTask(task.id);
        closeAllModals();
    };
    
    confirmationModal.classList.remove('hidden');
}

async function deleteTask(taskId) {
    try {
        const response = await fetch(`${ENDPOINTS.TASKS}/${taskId}`, {
            method: 'DELETE',
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${localStorage.getItem("authToken")}`,
            }
        });
        
        if (!response.ok) {
            throw new Error('Failed to delete task');
        }
        
        showNotification('Task deleted successfully', 'success');
        const tasks = await fetchTasks(selectedGroupId);
        renderTaskList(tasks);
    } catch (error) {
        console.error('Error deleting task:', error);
        showNotification('Failed to delete task', 'error');
    }
}

// UI Helpers
function closeAllModals() {
    groupModal.classList.add('hidden');
    taskModal.classList.add('hidden');
    confirmationModal.classList.add('hidden');
}

function showNotification(message, type = 'info') {
    // You can implement a notification system here
    console.log(`${type.toUpperCase()}: ${message}`);
    
    // Simple alert for now
    if (type === 'error') {
        alert(`Error: ${message}`);
    }
}

// Close modal when clicking outside
window.addEventListener('click', (event) => {
    if (event.target === groupModal) {
        groupModal.classList.add('hidden');
    } else if (event.target === taskModal) {
        taskModal.classList.add('hidden');
    } else if (event.target === confirmationModal) {
        confirmationModal.classList.add('hidden');
    }
});