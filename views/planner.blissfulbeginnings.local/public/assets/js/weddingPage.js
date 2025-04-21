const path = window.location.pathname;
const pathParts = path.split("/");
const weddingID = pathParts[pathParts.length - 1];

// Function to render messages to the chat container
function renderMessages() {
  const chatContainer = document.querySelector(".chat-show-area");
  chatContainer.innerHTML = "";

  const wsUrl = "ws://localhost:8080/";

  const socket = new WebSocket(wsUrl);
  const messageInput = document.getElementById("chat-type-field");
  const sendBtn = document.getElementById("send-button");

  socket.onopen = () => {
    socket.send(
      JSON.stringify({
        weddingID: weddingID,
      })
    );
  };

  socket.onmessage = (event) => {
    const messages = JSON.parse(event.data);
    console.log(messages);
    messages.forEach((message) => {
      sender = message.role === "planner" ? "me" : message.role;
      if (!message) {
        return;
      }
      if (message.relativePath) {
        appendImageMessage(message.relativePath, message.timestamp, sender);
        return;
      } else {
        appendTextMessage(message.message, message.timestamp, sender);
      }
    });
  };

  socket.onerror = (error) => {
    console.error("WebSocket error:", error);
    chatContainer.innerHTML = "<p>Unexpected error occured</p>";
  };

  socket.onclose = () => {
    console.log("WebSocket connection closed.");
  };

  function appendTextMessage(message, timestamp, sender) {
    const messageElement = document.createElement("div");
    messageElement.classList.add("message");
    messageElement.innerHTML =
      `<div class="sender ${sender}">` +
      sender +
      ": </div><p class=message-text>" +
      message +
      "</p>";
    messageElement.dataset.timestamp = timestamp;
    chatContainer.appendChild(messageElement);
  }
  function appendImageMessage(imageReference, timestamp, sender) {
    const imageElement = document.createElement("div");
    imageElement.classList.add("message", "image");
    imageElement.dataset.timestamp = timestamp;
    imageElement.style.display = "flex";
    imageElement.style.flexDirection = "column";

    const senderElement = document.createElement("div");
    senderElement.classList.add("sender", sender);
    senderElement.innerHTML = '<h4">' + sender + "</h4>";
    imageElement.appendChild(senderElement);
    const img = document.createElement('img');
    img.src = "http://cdn.blissfulbeginnings.com" + imageReference;
    img.alt = "Uploaded Image";
    img.classList.add('chat-image');

    imageElement.appendChild(img);
    chatContainer.appendChild(imageElement);
  }

  sendBtn.addEventListener("click", () => {
    timestamp = new Date().toISOString();
    timestamp = timestamp.replace("T", " ").split(".")[0];
    const message = messageInput.value.trim();
    if (message) {
      chatMessage = {
        sender: "planner",
        message: message,
        timestamp: timestamp,
      };
      socket.send(JSON.stringify(chatMessage));
      console.log(chatMessage);
      appendTextMessage(message, timestamp, "me");
      messageInput.value = "";
    }
  });

  messageInput.addEventListener("keypress", (event) => {
    if (event.key === "Enter") {
      sendBtn.click();
    }
  });

  document
    .getElementById("imageUpload")
    .addEventListener("change", async function (event) {
      const file = event.target.files[0]; // Get the selected file

      // Ensure a file was selected
      if (!file) {
        alert("No file selected.");
        return;
      }

      const validImageTypes = ["image/jpeg", "image/png", "image/gif"];
      if (!validImageTypes.includes(file.type)) {
        alert("Please upload a valid image file (JPEG, PNG, GIF).");
        return;
      }

      const maxSize = 2 * 1024 * 1024;
      if (file.size > maxSize) {
        alert("File size must be less than 2 MB.");
        return;
      }

      const metaWithImage = {
        timestamp: formData.timestamp,
        role: "planner",
        relativePath: imageReference,
        Image: "image_reference",
      };

      try {
        const response = await fetch("/chat/upload-image/" + weddingID, {
          method: "POST",
          body: formData,
        });

        if (!response.ok) {
          throw new Error(`Failed to upload image. Status: ${response.status}`);
        }

        const data = await response.json();

        if (!data.storagePath) {
          throw new Error(
            "Invalid response from server. No storage path provided."
          );
        }

        const imageReference = data.storagePath;

        const metaWithImage = {
          timestamp: formData.timestamp,
          sender: "planner",
          imageReference: imageReference,
          Image: "image_reference",
        };

        socket.send(JSON.stringify(metaWithImage));

        appendImageMessage(
          imageReference,
          metaWithImage.timestamp,
          metaWithImage.sender
        );
        alert("Image sent successfully!");
      } catch (error) {
        console.error("Error:", error);
        alert("An error occurred while uploading the image.");
      }
    });

  chatContainer.scrollTop = chatContainer.scrollHeight;
}
document.addEventListener("DOMContentLoaded", renderMessages);

document.addEventListener("DOMContentLoaded", function () {
  function updateProgressBar(totalTasks, completedTasks) {
    const progressBar = document.getElementById("progressBar");
    const percentage = document.getElementById("weddingProgressPrecentage");
    const valueOfPercentage = ((completedTasks / totalTasks) * 100).toFixed(1);
    percentage.innerHTML = valueOfPercentage + "%";

    progressBar.style.width = `${valueOfPercentage}%`;

    // Convert valueOfPercentage to a number for proper comparison
    const numericPercentage = parseFloat(valueOfPercentage);

    if (numericPercentage === 100) {
      progressBar.style.backgroundColor = "#4caf50"; // Green
    } else if (numericPercentage >= 50 && numericPercentage < 100) {
      progressBar.style.backgroundColor = "#ffc107"; // Yellow
    } else if (numericPercentage < 50) {
      progressBar.style.backgroundColor = "#f44336"; // Red
    }
  }

  function updateBudgetBar(totalTasks, completedTasks) {
    const progressBar = document.getElementById("budgetBar");
    const percentage = document.getElementById("budgetProgressPrecentage");
    const valueOfPercentage = ((completedTasks / totalTasks) * 100).toFixed(1);
    percentage.innerHTML = valueOfPercentage + "%";

    progressBar.style.width = `${valueOfPercentage}%`;

    // Convert valueOfPercentage to a number for proper comparison
    const numericPercentage = parseFloat(valueOfPercentage);

    if (numericPercentage === 100) {
      progressBar.style.backgroundColor = "#4caf50"; // Green
    } else if (numericPercentage >= 50 && numericPercentage < 100) {
      progressBar.style.backgroundColor = "#ffc107"; // Yellow
    } else if (numericPercentage < 50) {
      progressBar.style.backgroundColor = "#f44336"; // Red
    }
  }

  fetch(`/fetch-for-budget-progress/${weddingID}`, {
    method: "GET",
    headers: {
      Authorization: `Bearer ${localStorage.getItem("authToken")}`,
      "Content-Type": "application/json",
    },
  })
    .then((response) => {
      if (response.status == 401) {
        window.location.href = "/signin";
      } else if (response.status == 500) {
        throw new Error("Internal Server Error");
      }
      return response.json();
    })
    .then((data) => {
      const totalBudget = data.totalPackagesValue;
      const paidValue = data.currentPaid;
      updateBudgetBar(totalBudget, paidValue);
    })
    .catch((error) => {
      console.error("Error fetching budget progress:", error);
    });

  fetch(`/fetch-for-wedding-progress/${weddingID}`, {
    method: "GET",
    headers: {
      Authorization: `Bearer ${localStorage.getItem("authToken")}`,
      "Content-Type": "application/json",
    },
  })
    .then((response) => {
      if (response.status == 401) {
        window.location.href = "/signin";
      } else if (response.status == 500) {
        throw new Error("Internal Server Error");
      }
      return response.json();
    })
    .then((data) => {
      const taskCount = data.tasks.taskCount;
      const finishedTaskCount = data.tasks.finishedTaskCount;
      updateProgressBar(taskCount, finishedTaskCount);
    })
    .catch((error) => {
      console.error("Error fetching wedding progress:", error);
    });

  const weddingTitleElement = document.querySelector(
    ".wedding-dashboard-title"
  );
  const vendorCardContainer = document.querySelector(".vendor-cards");

  // Fetch wedding data and set the title
  fetch(`/fetch-wedding/${weddingID}`, {
    method: "GET",
    headers: {
      Authorization: `Bearer ${localStorage.getItem("authToken")}`,
      "Content-Type": "application/json",
    },
  })
    .then((response) => {
      if (response.status == 401) {
        window.location.href = "/signin";
      } else if (response.status == 500) {
        throw new Error("Internal Server Error");
      }
      return response.json();
    })
    .then((wedding) => {
      weddingTitleElement.textContent = `${wedding.weddingTitle} s' Wedding`;
      if (wedding.weddingState == "new") {
        window.href = `/select-packages/${weddingID}`;
      } else if (wedding.weddingState == "unassigned") {
        messageDiv = document.createElement("div");
        messageDiv.classList.add("message");
        messageDiv.innerHTML =
          "<h1>Waiting for the Customer to choose a package</h1>";
        vendorCardContainer.appendChild(messageDiv);
      } else if (wedding.weddingState == "ongoing") {
        // Checks if the wedding is over and ask to end the service
        const targetDate = new Date(wedding.date);
        const today = new Date();
        const differenceInTime = targetDate - today;
        const remainingDays = Math.ceil(
          differenceInTime / (1000 * 60 * 60 * 24)
        );
        if(remainingDays < 0) {
          console.log("Wedding is over");
          completeButton = document.createElement("button");
          completeButton.classList.add("completeButton");
          completeButton.innerHTML = "Mark as Completed";
          completeButton.addEventListener("click", () => {
            fetch(`/complete-wedding/${weddingID}`, {
              method: "GET",
              headers: {
                Authorization: `Bearer ${localStorage.getItem("authToken")}`,
                "Content-Type": "application/json",
              },
            })
              .then((response) => {
                if (response.status == 401) {
                  alert("Unauthorized");
                  // window.location.href = "/signin";
                } else if (response.status == 500) {
                  throw new Error("Internal Server Error");
                }
                return response.json();
              })
              .then((data) => {
                alert("Wedding successfully marked as completed");
                window.location.href = `/wedding/${weddingID}`;

              })
              .catch((error) => {
                console.error("Error fetching wedding:", error);
              });
          })
          document.querySelector(".miscellanous").appendChild(completeButton);
        }

        fetch(`/fetch-assigned-vendors/${weddingID}`, {
          method: "GET",
          headers: {
            Authorization: `Bearer ${localStorage.getItem("authToken")}`,
            "Content-Type": "application/json",
          },
        })
          .then((res) => res.json())
          .then((vendors) => {
            vendors.forEach((vendor) => {
              const card = document.createElement("div");
              card.classList.add("vendor-card");
              card.innerHTML = `<div class="businessName">${vendor.businessName}</div><div class="vendorType">${vendor.typeID}</div>`;

              const taskArea = document.createElement("div");
              taskArea.classList.add("taskArea");
              taskArea.textContent = "Tasks:";
              taskArea.id = vendor.assignmentID;

              const addButton = document.createElement("button");
              addButton.classList.add("addButton");
              addButton.innerHTML = "&#x2795;";
              taskArea.appendChild(addButton);

              const taskShowArea = document.createElement("div");
              taskShowArea.classList.add("taskShowArea");
              taskArea.appendChild(taskShowArea);

              card.appendChild(taskArea);
              vendorCardContainer.appendChild(card);

              const payButton = document.createElement("button");
              payButton.classList.add("payButton");
              if (vendor.isPaid == 0) {
                payButton.innerHTML = "Pay";
                card.appendChild(payButton);

                payButton.addEventListener("click", function (event) {
                  window.location.href = `/wedding/${weddingID}/${vendor.assignmentID}`;
                });
              } else {
                payButton.innerHTML = "Paid";
                card.appendChild(payButton);
              }

              // Fetch assignment ID for the vendor
              fetch(`/tasks-for-assignments/${vendor.assignmentID}`, {
                method: "GET",
                headers: {
                  Authorization: `Bearer ${localStorage.getItem("authToken")}`,
                  "Content-Type": "application/json",
                },
              })
                .then((res) => {
                  if (res.status == 401) {
                    window.location.href = "/signin";
                  } else if (res.status == 200) {
                    return res.json();
                  } else {
                    throw new Error("Network response was not ok");
                  }
                })
                .then((tasks) => {
                  tasks.forEach((task) => {
                    if (task.state == "ongoing") {
                      const taskDetailsArea = document.createElement("div");
                      taskDetailsArea.classList.add("taskDetailsArea");
                      taskDetailsArea.innerHTML = `
                    <div class="taskCSS">${task.description} before ${task.dateToFinish}</div>
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

                      taskEditButton.addEventListener(
                        "click",
                        function (event) {
                          const taskID = event.target.dataset.taskID;

                          modal.classList.add("show");

                          document.getElementById("taskDescription").value =
                            task.description;
                          document.getElementById("dateToFinish").value =
                            task.dateToFinish;
                          document.getElementById("taskForm").dataset.taskID =
                            taskID;
                          document.getElementById("taskForm").onsubmit =
                            updateFunction;
                        }
                      );

                      taskDeleteButton.addEventListener(
                        "click",
                        function (event) {
                          const confirmed = confirm(
                            "Are you sure you want to delete?"
                          );
                          if (confirmed) {
                            const taskID = event.target.dataset.taskID;

                            document.getElementById("taskForm").dataset.taskID =
                              taskID;
                            console.log(taskID);

                            fetch(`/delete-tasks/${taskID}`, {
                              method: "DELETE",
                              headers: {
                                Authorization: `Bearer ${localStorage.getItem(
                                  "authToken"
                                )}`,
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
                          }
                        }
                      );
                    } else {
                      const taskDetailsArea = document.createElement("div");
                      taskDetailsArea.classList.add("taskDetailsArea");

                      taskDetailsArea.classList.add("completed-task");
                      taskDetailsArea.innerHTML = `<div class="taskCSS">${task.description}</div>`;

                      taskShowArea.appendChild(taskDetailsArea);
                    }
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
      } else if (wedding.weddingState == "finished") {
        function createVendorCard(vendorName, vendorType, rating) {
          const card = document.createElement('div');
          card.classList.add('vendor-card');
          const nameElement = document.createElement('h2');
          nameElement.textContent = vendorName;
          const typeElement = document.createElement('p');
          typeElement.textContent = vendorType;
          const ratingElement = document.createElement('div');
          ratingElement.classList.add('vendor-rating');
          for (let i = 1; i <= 5; i++) {
              const star = document.createElement('span');
              star.classList.add('star');
              star.innerHTML = '&#9733;';  // Unicode star
              if (i > rating) {
                  star.classList.add('unfilled');
              }
              ratingElement.appendChild(star);
          }
      
          card.appendChild(nameElement);
          card.appendChild(typeElement);
          card.appendChild(ratingElement);
      
          return card;
      }

        fetch(
          `/get-vendor-ratings/${weddingID}`,{
            method: "GET",
            headers: {
              Authorization: `Bearer ${localStorage.getItem("authToken")}`,
              "Content-Type": "application/json",
            },
          }
        ).then((res) => {
          if (res.status == 401) {
            window.location.href = "/signin";
          } else if (res.status == 200) {
            return res.json();
          } else {
            throw new Error("Network response was not ok");
          }
        }).then((data) => {
          const main = document.querySelector('main');
          const cardContainer = document.createElement("div");
          cardContainer.classList.add("rating-card-container");
          data.forEach((vendor) => {
            cardContainer.appendChild(createVendorCard(vendor.businessName, vendor.typeID, vendor.rating));
          });
          main.appendChild(cardContainer);
        })
      }
    })
    .catch((error) => {
      console.error("Error fetching wedding title:", error);
      weddingTitleElement.textContent = "Wedding Dashboard";
    });

  // Fetch vendors and render vendor cards

  // Modal and task form logic
  const modal = document.getElementById("taskFormModal");
  const closeModalButton = document.getElementById("closeModal");
  const taskForm = document.getElementById("taskForm");

  document.addEventListener("click", function (event) {
    if (event.target.classList.contains("addButton")) {
      const assignmentID = event.target.parentNode.id;
      taskForm.querySelector("input[name='assignmentID']").value = assignmentID;
      modal.classList.add("show");
      document.getElementById("taskForm").onsubmit = createFunction;
    }
  });

  closeModalButton.addEventListener("click", function () {
    taskForm.reset();
    modal.classList.remove("show");
  });

  function createFunction(e) {
    e.preventDefault();
    const taskDescription = document.getElementById("taskDescription").value;
    const dateToFinish = document.getElementById("dateToFinish").value;
    const assignmentID = taskForm.querySelector(
      "input[name='assignmentID']"
    ).value;
    console.log(assignmentID);

    const today = new Date();
    const formattedToday = today.toISOString().split("T")[0];
    if (dateToFinish <= formattedToday) {
      alert("Please select a date in the future.");
      return;

    }
    const taskDetails = {
      description: taskDescription,
      dateToFinish: dateToFinish,
      assignmentID,
    };

    fetch("/tasks-create-for-vendors/" + assignmentID, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${localStorage.getItem("authToken")}`,
      },
      body: JSON.stringify(taskDetails),
    })
      .then((res) => {
        if (res.status === 401) {
          window.location.href = "/signin";
        }
        if (res.status === 200) {
          return res.json();
        }
      })
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

    fetch(`/update-tasks/${taskID}`, {
      method: "POST",
      headers: {
        Authorization: `Bearer ${localStorage.getItem("authToken")}`,
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
});
