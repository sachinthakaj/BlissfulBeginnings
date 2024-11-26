document.addEventListener("DOMContentLoaded", function () {
  const weddingTitleElement = document.querySelector(
    ".wedding-dashboard-title"
  );
  const vendorCardContainer = document.querySelector(".vendor-cards");

  let queryString = new URLSearchParams(window.location.search.slice(1));
  const weddingID = queryString.get("id");

  // Fetch wedding data and set the title
  fetch("/fetch-wedding-data", {
    method: "GET",
    headers: {
      "Authorization": `Bearer ${localStorage.getItem('authToken')}`,
      "Content-Type": "application/json",
    },
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Failed to fetch wedding title");
      }
      return response.json();
    })
    .then((weddings) => {
      let wedding = weddings.find((wedding) => wedding.weddingID === weddingID);
      if (wedding) {
        weddingTitleElement.textContent = `${wedding.brideName} & ${wedding.groomName} s' Wedding`;
      } else {
        weddingTitleElement.textContent = "Wedding Dashboard";
      }
    })
    .catch((error) => {
      console.error("Error fetching wedding title:", error);
      weddingTitleElement.textContent = "Wedding Dashboard";
    });

  // Fetch vendors and render vendor cards
  fetch(`/vendors-for-wedding?weddingID=${weddingID}`, {
    method: "GET",
    headers: {
      'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
      "Content-Type": "application/json",
    },
  })
    .then((res) => res.json())
    .then((vendors) => {
      vendors.forEach((vendor) => {
        const card = document.createElement("div");
        card.classList.add("vendor-card");
        card.innerHTML = `<p>${vendor.businessName}</br></br>${vendor.typeID}</p>`;

        const taskArea = document.createElement("div");
        taskArea.classList.add("taskArea");
        taskArea.textContent = "Tasks:";

        const addButton = document.createElement("button");
        addButton.classList.add("addButton");
        addButton.innerHTML = "&#x2795;";
        taskArea.appendChild(addButton);

        const taskShowArea = document.createElement("div");
        taskShowArea.classList.add("taskShowArea");
        taskArea.appendChild(taskShowArea);

        card.appendChild(taskArea);
        vendorCardContainer.appendChild(card);

        // Fetch assignment ID for the vendor
        fetch(
          `/task-vendors-for-wedding?weddingID=${weddingID}&vendorID=${vendor.vendorID}`,
          {
            method: "GET",
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
              "Content-Type": "application/json",
            },
          }
        )
          .then((res) => res.json())
          .then((data) => {
            const assignmentID = data.assignmentID;
            addButton.dataset.assignmentID = assignmentID;

            // Fetch tasks for the assignmentID
            fetch(`/fetch-all-tasks?assignmentID=${assignmentID}`, {
              method: "GET",
              headers: {
            'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
                "Content-Type": "application/json",
              },
            })
              .then((res) => res.json())
              .then((tasks) => {
                console.log(tasks);
                tasks.forEach((task) => {
                  const taskDetailsArea = document.createElement("div");
                  taskDetailsArea.classList.add("taskDetailsArea");
                  taskDetailsArea.innerHTML = `
                    <p>${task.description} - ${task.dateToFinish}</p>
                  `;

                  const taskActionArea = document.createElement("div");
                  taskActionArea.classList.add("taskActionArea");

                  const taskEditButton = document.createElement("button");
                  taskEditButton.classList.add("taskEditButton");
                  taskEditButton.innerHTML = "&#9998";
                  taskActionArea.appendChild(taskEditButton);

                  const taskDeleteButton = document.createElement("button");
                  taskDeleteButton.classList.add("taskDeleteButton");
                  taskDeleteButton.innerHTML = "&#128465";
                  taskActionArea.appendChild(taskDeleteButton);

                  taskDetailsArea.appendChild(taskActionArea);

                  taskShowArea.appendChild(taskDetailsArea);

                  taskEditButton.dataset.taskID = task.taskID;
                  taskDeleteButton.dataset.taskID = task.taskID;

                  taskEditButton.addEventListener("click", function (event) {
                    const taskID = event.target.dataset.taskID;

                    modal.classList.add("show");

                    document.getElementById("taskDescription").value =
                      task.description;
                    document.getElementById("dateToFinish").value =
                      task.dateToFinish;
                    document.getElementById("taskForm").dataset.taskID = taskID;
                    document.getElementById("taskForm").onsubmit =
                      updateFunction;
                  });


                  taskDeleteButton.addEventListener("click", function (event) {
                    const taskID = event.target.dataset.taskID;


                    document.getElementById("taskForm").dataset.taskID = taskID;
                    console.log(taskID);

                    fetch("/delete-tasks", {
                      method: "DELETE",
                      headers: {
            'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
                        "Content-Type": "application/json",
                      },
                      body: JSON.stringify({ taskID: taskID }),
                    })
                      .then((res) => res.json())
                      .then((data) => {
                        if (data.status === "success") {
                          alert(data.message);
                          window.location.reload();
                        } else {
                          alert("Error: " + data.message);
                        }
                      })
                      .catch((error) => {
                        console.error("Error Creating Task:", error);
                      });



                  });
                });
              })
              .catch((error) => {
                console.error("Error fetching tasks:", error);
              });
          })
          .catch((error) => {
            console.error("Error fetching assignmentID:", error);
          });
      });
    })
    .catch((error) => {
      console.error("Error fetching vendors:", error);
    });

  // Modal and task form logic
  const modal = document.getElementById("taskFormModal");
  const closeModalButton = document.getElementById("closeModal");
  const taskForm = document.getElementById("taskForm");

  document.addEventListener("click", function (event) {
    if (event.target.classList.contains("addButton")) {
      const assignmentID = event.target.dataset.assignmentID;
      taskForm.querySelector("input[name='assignmentID']").value = assignmentID;
      modal.classList.add("show");
      document.getElementById("taskForm").onsubmit = createFunction;
    }
  });

  closeModalButton.addEventListener("click", function () {
    modal.classList.remove("show");
  });

  function createFunction(e) {
    e.preventDefault();
    const taskDescription = document.getElementById("taskDescription").value;
    const dateToFinish = document.getElementById("dateToFinish").value;
    const assignmentID = taskForm.querySelector(
      "input[name='assignmentID']"
    ).value;

    const taskDetails = {
      description: taskDescription,
      dateToFinish: dateToFinish,
      assignmentID,
    };

    fetch("/tasks-create-for-vendors", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(taskDetails),
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.status === "success") {
          alert(data.message);
          window.location.reload();
        } else {
          alert("Error: " + data.message);
        }
      })
      .catch((error) => {
        console.error("Error Creating Task:", error);
      });
    modal.classList.remove("show");
    taskForm.reset();
  }

  function updateFunction(e) {
    e.preventDefault();
    const taskDescription = document.getElementById("taskDescription").value;
    const dateToFinish = document.getElementById("dateToFinish").value;
    const taskID = document.getElementById("taskForm").dataset.taskID;

    const taskDetails = {
      description: taskDescription,
      dateToFinish: dateToFinish,
      taskID,
    };

    fetch("/update-tasks", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(taskDetails),
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.status === "success") {
          alert(data.message);
          window.location.reload();
        } else {
          alert("Error: " + data.message);
        }
      })
      .catch((error) => {
        console.error("Error Creating Task:", error);
      });
    modal.classList.remove("show");
    taskForm.reset();
  }

  // taskForm.addEventListener("click", function (e) {

  // });
});
