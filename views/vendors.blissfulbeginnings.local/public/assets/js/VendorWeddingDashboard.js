const path = window.location.pathname;
const pathParts = path.split("/");
const vendorID = pathParts[pathParts.length - 3];
const assignmentID = pathParts[pathParts.length - 1];

const weddingID = getWeddingIdFRomAssignmentID(assignmentID);
let vendorName = 'vendor'

async function getWeddingIdFRomAssignmentID(assignmentID) {
  try {
    const response = await fetch(`/vendor/${vendorID}/assignment/${assignmentID}/get-wedding-id`, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
      },
    });
    if (response.status == 401) {
      // window.location.href = '/signin';
    }
    data = await response.json();
    return data;
  } catch (error) {
    console.error(error)
    // window.location.href = '/signin';
  }
}


function updateProgressBar(totalTasks, completedTasks) {
  const progressBar = document.getElementById("progressBar");
  const percentage = document.getElementById("weddingProgressPrecentage");
  const valueOfPercentage = ((completedTasks / totalTasks) * 100).toFixed(1);
  percentage.innerHTML = isNaN(valueOfPercentage) ? "0.0%" : valueOfPercentage + "%";

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

fetch(`/fetch_for_progress/${vendorID}/${assignmentID}`, {
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
    console.log(data);

    const taskCount = data.tasks.taskCount;
    const finishedTaskCount = data.tasks.finishedTaskCount;
    updateProgressBar(taskCount, finishedTaskCount);
  })
  .catch((error) => {
    console.error("Error fetching wedding progress:", error);
  });

function render() {
  const scrollContainer = document.querySelector(".slide-content");
  const backBtn = document.getElementById("backBtn");
  const nextBtn = document.getElementById("nextBtn");

  document.querySelector(".go-back").addEventListener("click", () => {
    window.location.href = `/vendor/${vendorID}`;
  });

  fetch(`/vendor/${vendorID}/assignment/${assignmentID}/get-tasks`, {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${localStorage.getItem("authToken")}`,
    },
  })
    .then((response) => {
      if (response.status === 401) {
        window.location.href = "/signin";
      } else {
        return response.json();
      }
    })
    .then((details) => {
      // function to create a card DOM element
      function createCard(cardData) {
        const card = document.createElement("div");
        card.className = "card";
        card.id = cardData.taskID;

        const currentDate = new Date();
        const deadlineDate = new Date(cardData.dateToFinish);
        const timeDiff = deadlineDate - currentDate;
        const daysRemaining = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));

        card.innerHTML = `
                <div class="image-content">
                    <span class="overlay"></span>
                </div>
                <div class="card-content">
                    <h2 class="name">${cardData.description}</h2>
                    <h5 class="sub-name">Deadline: ${cardData.dateToFinish}</h5>
                    <h5 class="sub-name">Days Remaining: ${daysRemaining}</h5>
                </div>
            `;
        const taskStateBtn = document.createElement("button");
        
        if (cardData.state == "ongoing") {
          taskStateBtn.classList.add("card-button");
          taskStateBtn.textContent = "Mark as Done";
          taskStateBtn.addEventListener("click", () => {
            const conformed = confirm(
              "Are you sure you want to mark this task as done?"
            );
            if (conformed) {
              fetch(`/task_state_update/${vendorID}`, {
                method: "POST",
                headers: {
                  "Content-Type": "application/json",
                  Authorization: `Bearer ${localStorage.getItem("authToken")}`,
                },
                body: JSON.stringify({
                  taskID: cardData.taskID,
                }),
              })
                .then((response) => {
                  if (response.status === 401) {
                    window.location.href = "/signin";
                  } else {
                    return response.json();
                  }
                })
                .then((data) => {
                  if (data.status === "success") {
                    alert(data.message);
                    window.location.reload();
                  } else {
                    alert("Error: " + data.error);
                  }
                })
                .catch((error) => {
                  console.error("Error updating Task:", error);
                });
            }
          });
        } else {
          taskStateBtn.textContent = "Completed";
          taskStateBtn.classList.add("done-task-button");
          taskStateBtn.disabled = true;
          taskStateBtn.classList.add("doneButton");
        }


        card.appendChild(taskStateBtn);
        return card;
      }

      // cards into groups of 3
      function loadCards(cards) {
        scrollContainer.innerHTML = "";

        if (cards.length === 0) {
          scrollContainer.innerHTML = `
                    <div class="no-tasks">
                        <h2>No given tasks</h2>
                    </div>`;
          return;
        }

        for (let i = 0; i < cards.length; i += 3) {
          const wrapper = document.createElement("div");
          wrapper.className = "card-wrapper";

          const group = cards.slice(i, i + 3);
          group.forEach((cardData) => {
            const cardElement = createCard(cardData);
            wrapper.appendChild(cardElement);
          });

          scrollContainer.appendChild(wrapper);
        }
      }

      // load all cards
      loadCards(details.tasks);

      const weddingTitle = document.querySelector(".wedding-title");
      weddingTitle.innerHTML = details.weddingDetails.weddingTitle;

      const targetDate = new Date(details.weddingDetails.date);
      const today = new Date();
      const differenceInTime = targetDate - today;
      const remainingDays = Math.ceil(differenceInTime / (1000 * 60 * 60 * 24));
      document.getElementById("days-left").innerHTML =
        remainingDays > 0 ? `${remainingDays} days left` : "Happy wedded life!";

      const weddingProgress = document.getElementById("wedding-progress-bar");
      const budgetProgress = document.getElementById("budget-progress-bar");
      getProgress(weddingProgress, budgetProgress);
    });
  // navigation buttons to navigate toright and toleft
  nextBtn.addEventListener("click", () => {
    scrollContainer.scrollLeft += 900;
    scrollContainer.style.scrollBehavior = "smooth";
  });

  backBtn.addEventListener("click", () => {
    scrollContainer.scrollLeft -= 900;
    scrollContainer.style.scrollBehavior = "smooth";
  });

  // scroll behavior
  scrollContainer.addEventListener("wheel", (evt) => {
    evt.preventDefault();
    scrollContainer.scrollLeft += evt.deltaX;
    scrollContainer.style.scrollBehavior = "auto";
  });

  // const slideContent = document.querySelector('.slide-content');
  // cardsData.forEach(cardData => {
  //     slideContent.innerHTML += createCard(cardData);
  // });
}

function renderMessages() {
  const chatContainer = document.querySelector(".chat-show-area");
  chatContainer.innerHTML = "";

  const wsUrl = "ws://localhost:8080/";

  const socket = new WebSocket(wsUrl);
  const messageInput = document.getElementById("chat-type-field");
  const sendBtn = document.getElementById("send-button");

  console.log(weddingID);
  socket.onopen = async () => {
    weddingID.then((data) => {
      handshake = JSON.stringify({
        weddingID: data['weddingID']
      })
      console.log('WebSocket connection opened. Sending wedding ID...');
      console.log(handshake);
      socket.send(handshake);
      vendorName = data['businessName'];
    })
  };

  socket.onmessage = (event) => {
    const messages = JSON.parse(event.data);
    console.log(messages);
    messages.forEach((message) => {
      if (!message) {
        return;
      }
      const sender = (message.role === vendorName) ? 'me' : message.role;
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
    senderElement.classList.add(sender);
    senderElement.classList.add("sender");
    senderElement.innerHTML = '<h4">' + sender + "</h4>";
    imageElement.appendChild(senderElement);
    const img = document.createElement("img");
    img.src = "http://cdn.blissfulbeginnings.com" + imageReference;
    img.alt = "Uploaded Image";
    img.classList.add("chat-image");

    imageElement.appendChild(img);
    chatContainer.appendChild(imageElement);
  }

  sendBtn.addEventListener("click", () => {
    timestamp = new Date().toISOString();
    timestamp = timestamp.replace("T", " ").split(".")[0];
    const message = messageInput.value.trim();
    if (message) {
      chatMessage = {
        role: vendorName,
        message: message,
        timestamp: timestamp,
      };
      socket.send(JSON.stringify(chatMessage));
      console.log(chatMessage);
      appendTextMessage(message, timestamp, "me");
      messageInput.value = "";
      chatContainer.scrollTop = chatContainer.scrollHeight;
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

      let maxSize = 2 * 1024 * 1024;
      if (file.size > maxSize) {
        alert("File size must be less than 2 MB.");
        return;
      }

      timestamp = new Date().toISOString();
      timestamp = timestamp.replace("T", " ").split(".")[0];
      sender = "planner";
      let formData = new FormData();
      formData.append("image", file);
      formData.append("timestamp", timestamp);
      formData.append("sender", JSON.stringify(sender));


      maxSize = 2 * 1024 * 1024;
      if (file.size > maxSize) {
        alert("File size must be less than 2 MB.");
        return;
      }


      timestamp = new Date().toISOString()
      timestamp = timestamp.replace('T', ' ').split('.')[0];
      role = vendorName;
      formData = new FormData();
      formData.append("image", file);
      formData.append("timestamp", timestamp);
      formData.append("role", JSON.stringify(role));

      try {
        weddingID.then(
          async _data => {
            const response = await fetch("/chat/upload-image/" + _data, {
              method: "POST",
              body: formData,
            });

            if (!response.ok) {
              throw new Error(
                `Failed to upload image. Status: ${response.status}`
              );
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
              role: vendorName,
              relativePath: imageReference,
              Image: "image_reference",
            };

            socket.send(JSON.stringify(metaWithImage));

            appendImageMessage(
              imageReference,
              metaWithImage.timestamp,
              metaWithImage.sender
            );
            alert("Image sent successfully!");
          });
      } catch (error) {
        console.error("Error:", error);
        alert("An error occurred while uploading the image.");
      }
    });

  chatContainer.scrollTop = chatContainer.scrollHeight;
}
document.addEventListener("DOMContentLoaded", renderMessages);

document.addEventListener("DOMContentLoaded", render);

document.addEventListener("DOMContentLoaded", () => {
  const scheduleButton = document.getElementById("scheduleButtonId");
  const scheduleListContainer = document.getElementById(
    "scheduleListContainer"
  );
  const closeButton = document.getElementById("closeModalButton");
  const model = document.getElementById("eventModal");
  const eventForm = document.getElementById("eventForm");
  const addEventButton = document.getElementById("addEventButton");
  const scheduleList = document.getElementById("scheduleList");

  function showEventsOnEventContainer() {
    fetch(`/get-events/${vendorID}/${assignmentID}`, {
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
      .then((data) => {
        console.log(data);
        data.events.forEach((event) => {
          if (event.state == "scheduled") {
            const scheduleItem = document.createElement("div");
            scheduleItem.classList.add("schedule-item");
            scheduleList.appendChild(scheduleItem);

            const eventDetailsArea = document.createElement("div");
            eventDetailsArea.classList.add("eventDetailsArea");
            scheduleItem.appendChild(eventDetailsArea);
            eventDetailsArea.innerHTML = `${event.date}  |  ${event.description}  |  ${event.time}`;

            const eventActionArea = document.createElement("div");
            eventActionArea.classList.add("eventActionArea");
            scheduleItem.appendChild(eventActionArea);

            const eventEditButton = document.createElement("button");
            eventEditButton.classList.add("eventEditButton");
            eventEditButton.innerHTML = "&#9998";
            eventActionArea.appendChild(eventEditButton);

            const eventDeleteButton = document.createElement("button");
            eventDeleteButton.classList.add("eventDeleteButton");
            eventDeleteButton.innerHTML = "&#128465";
            eventActionArea.appendChild(eventDeleteButton);

            const eventFinishedButton = document.createElement("button");
            eventFinishedButton.classList.add("eventFinishedButton");
            eventFinishedButton.innerHTML = "&#10003;";
            eventActionArea.appendChild(eventFinishedButton);

            eventEditButton.dataset.eventID = event.eventID;
            eventDeleteButton.dataset.eventID = event.eventID;
            eventFinishedButton.dataset.eventID = event.eventID;

            eventEditButton.addEventListener("click", function (event) {
              scheduleList.innerHTML = "";
              scheduleListContainer.style.display = "none";
              model.style.display = "block";

              const eventID = event.target.dataset.eventID;
              const selectedEvent = data.events.find(
                (ev) => ev.eventID === eventID
              );

              document.getElementById("eventDescription").value =
                selectedEvent.description;
              document.getElementById("eventDate").value = selectedEvent.date;
              document.getElementById("eventForm").dataset.eventID = eventID;
              document.getElementById("eventTime").value = selectedEvent.time;

              document.getElementById("eventForm").onsubmit = updateEvent;
            });

            eventDeleteButton.addEventListener("click", function (event) {
              deleteEvent(event);
            });

            eventFinishedButton.addEventListener("click", function (event) {
              finishedEvent(event);
            });
          } else {
            const scheduleItem = document.createElement("div");
            scheduleItem.classList.add("schedule-item");
            scheduleItem.innerHTML = `${event.date}      |      ${event.description}      |      ${event.time}`;
            scheduleList.appendChild(scheduleItem);


            const showDone = document.createElement("div");
            showDone.classList.add("showDone");
            scheduleItem.appendChild(showDone);
            showDone.innerHTML = "Done";
            showDone.style.color = "green";
          }
        });
      })

      .catch((error) => {
        console.error("Error fetching events", error);
      });
  }

  scheduleButton.addEventListener("click", () => {
    if (
      scheduleListContainer.style.display === "none" ||
      !scheduleListContainer.style.display
    ) {
      scheduleListContainer.style.display = "block"; // Show the container
      scheduleListContainer.scrollIntoView({ behavior: "smooth" });
      // Smooth scroll to the container
      showEventsOnEventContainer();
    } else {
      scheduleListContainer.style.display = "none"; // Hide the container
      scheduleList.innerHTML = ""; // Clear the list
    }
  });

  addEventButton.addEventListener("click", () => {
    scheduleList.innerHTML = "";
    scheduleListContainer.style.display = "none";
    model.style.display = "block";
    eventForm.reset();
    document.getElementById("eventForm").onsubmit = createEvent;
  });

  closeButton.addEventListener("click", () => {
    model.style.display = "none";
    eventForm.reset();
  });

  window.addEventListener("click", (event) => {
    if (event.target === model) {
      model.style.display = "none";
    }
  });

  function createEvent(e) {
    e.preventDefault();

    const eventDescription = document
      .getElementById("eventDescription")
      .value.trim();
    const eventDate = document.getElementById("eventDate").value;
    const eventTime = document.getElementById("eventTime").value;


    const eventDetails = {
      eventDescription: eventDescription,
      eventDate: eventDate,
      assignmentID: assignmentID,
      eventTime: eventTime,

    };

    fetch(`/event-creation/${vendorID}`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${localStorage.getItem("authToken")}`,
      },
      body: JSON.stringify(eventDetails),
    })
      .then((res) => {
        if (res.status === 401) {
          window.location.href = "/signin";
          return;
        }
        if (res.ok) {
          return res.json();
        }
        throw new Error(`Failed to create event. Status: ${res.status}`);
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
        console.error("Error Creating Event:", error);
        alert("An error occurred while creating the event. Please try again.");
      });

    model.style.display = "none";
    eventForm.reset();
  }

  function updateEvent(e) {
    e.preventDefault();

    const eventDescription = document
      .getElementById("eventDescription")
      .value.trim();
    const eventDate = document.getElementById("eventDate").value;
    const eventID = document.getElementById("eventForm").dataset.eventID;

    const eventDetails = {
      eventDescription: eventDescription,
      eventDate: eventDate,
      eventID: eventID,
    };

    fetch(`/update-event/${vendorID}`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${localStorage.getItem("authToken")}`,
      },
      body: JSON.stringify(eventDetails),
    })
      .then((res) => {
        if (res.status === 401) {
          window.location.href = "/signin";
          return;
        }
        if (res.ok) {
          return res.json();
        }
        throw new Error(`Failed to update event. Status: ${res.status}`);
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
        console.error("Error Creating Event:", error);
        alert("An error occurred while updating the event. Please try again.");
      });

    model.style.display = "none";
    eventForm.reset();
  }

  function deleteEvent(event) {
    const confirmed = confirm("Are you sure you want to delete?");
    if (confirmed) {
      const eventID = event.target.dataset.eventID;
      const eventDetails = {
        eventID: eventID,
      };
      fetch(`/delete-event/${vendorID}`, {
        method: "POST",
        headers: {
          Authorization: `Bearer ${localStorage.getItem("authToken")}`,
          "Content-Type": "application/json",
        },
        body: JSON.stringify(eventDetails),
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
          console.error("Error Deleting Event:", error);
        });
    }
  }

  function finishedEvent(event) {
    const confirmed = confirm("Are you sure you want to save this event as finished?");
    if (confirmed) {
      const eventID = event.target.dataset.eventID;
      const eventDetails = {
        eventID: eventID,
      };
      fetch(`/state-finished-events/${vendorID}`, {
        method: "POST",
        headers: {
          Authorization: `Bearer ${localStorage.getItem("authToken")}`,
          "Content-Type": "application/json",
        },
        body: JSON.stringify(eventDetails),
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
          console.error("Error changing state of Event:", error);
        });
    }
  }
});
