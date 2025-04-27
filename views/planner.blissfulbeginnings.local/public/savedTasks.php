<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Planner - Task Manager</title>
    <link rel="stylesheet" href="http://cdn.blissfulbeginnings.com/common-css/Common.css">
    <link rel="stylesheet" href="/public/assets/css/savedTasks.css">
</head>
<body>
    <header>
        <div class="nav-bar-logo-container">
            <img src="../assets/images/Logo.png" alt="Blissful Beginnings Logo" class="nav-bar-logo" />
        </div>
        <div class="wedding-title-container">
            <h1 class="wedding-title">Task Manager</h1>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="sidebar">
                <h2>Task Groups</h2>
                <div class="group-list-container">
                    <ul id="groupList" class="group-list"></ul>
                </div>
                <button id="addGroupBtn" class="primary-btn">Create New Group</button>
            </div>
            
            <div class="content">
                <div id="noGroupSelected" class="no-selection">
                    <p>Select a task group or create a new one</p>
                </div>
                
                <div id="groupDetails" class="group-details hidden">
                    <div class="group-header">
                        <h2 id="groupName">Group Name</h2>
                        <div class="group-actions">
                            <button id="editGroupBtn" class="secondary-btn">Edit Group</button>
                            <button id="deleteGroupBtn" class="danger-btn">Delete Group</button>
                        </div>
                    </div>
                    
                    <div class="group-info">
                        <p>Vendor Type: <span id="vendorType">Type</span></p>
                    </div>
                    
                    <div class="tasks-section">
                        <h3>Tasks</h3>
                        <div class="tasks-container">
                            <ul id="taskList" class="task-list"></ul>
                        </div>
                        <button id="addTaskBtn" class="primary-btn">Add Task</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Group Modal -->
    <div id="groupModal" class="modal hidden">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="groupModalTitle">Create Task Group</h2>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body">
                <form id="groupForm">
                    <div class="form-group">
                        <label for="groupNameInput">Group Name</label>
                        <input type="text" id="groupNameInput" required>
                    </div>
                    <div class="form-group">
                        <label for="vendorTypeSelect">Vendor Type</label>
                        <select id="vendorTypeSelect" required>
                            <option value="">Select a vendor type</option>
                            <option value="Dress designer">Dress designer</option>
                            <option value="Florist">Florist</option>
                            <option value="Salon">Salon</option>
                            <option value="Photographer">Photographer</option>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="secondary-btn cancel-btn">Cancel</button>
                        <button type="submit" class="primary-btn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Task Modal -->
    <div id="taskModal" class="modal hidden">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="taskModalTitle">Add Task</h2>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body">
                <form id="taskForm">
                    <div class="form-group">
                        <label for="taskNameInput">Task Name</label>
                        <input type="text" id="taskNameInput" required>
                    </div>
                    <div class="form-group">
                        <label for="taskDescriptionInput">Description</label>
                        <textarea id="taskDescriptionInput" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="taskDaysInput">Days to Complete</label>
                        <input type="number" id="taskDaysInput" min="1" required>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="secondary-btn cancel-btn">Cancel</button>
                        <button type="submit" class="primary-btn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="modal hidden">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Confirm Action</h2>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body">
                <p id="confirmationMessage">Are you sure you want to delete this item?</p>
                <div class="form-actions">
                    <button type="button" class="secondary-btn cancel-btn">Cancel</button>
                    <button type="button" id="confirmBtn" class="danger-btn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script src="./public/assets/js/savedTasks.js"></script>
</body>
</html>