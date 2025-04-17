const path = window.location.pathname;
const pathParts = path.split("/");
const vendorID = pathParts[pathParts.length - 3];
const assignmentID = pathParts[pathParts.length - 1];

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
    const finishedTaskCount= data.tasks.finishedTaskCount;
    updateProgressBar(taskCount, finishedTaskCount);



  })
  .catch((error) => {
    console.error("Error fetching wedding progress:", error);
  });


function render() {
  const scrollContainer = document.querySelector('.slide-content');
  const backBtn = document.getElementById('backBtn');
  const nextBtn = document.getElementById('nextBtn');

  document.querySelector('.go-back').addEventListener('click', () => {
    window.location.href = `/vendor/${vendorID}`;
  })

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

        card.innerHTML = `
                <div class="image-content">
                    <span class="overlay"></span>
                    <div class="card-image">
                        <img src="${cardData.imgSrc}" alt="" class="card-img">
                    </div>
                </div>
                <div class="card-content">
                    <h2 class="name">${cardData.title}</h2>
                    <h5 class="sub-name">Deadline: ${cardData.dateToFinish}</h5>
                    <p class="description">${cardData.description}</p>
                </div>
            `;
        const taskStateBtn = document.createElement("button");
        taskStateBtn.classList.add("card-button");

        if (cardData.state == "ongoing") {
          taskStateBtn.textContent = "Mark as Done";
        } else {
          taskStateBtn.textContent = "Completed";
          taskStateBtn.disabled = true;
          taskStateBtn.classList.add("doneButton");
        }

        
        taskStateBtn.addEventListener("click", () => {

          const conformed= confirm("Are you sure you want to mark this task as done?");
          if(conformed){  
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
  const chatContainer = document.querySelector('.chat-show-area');
  chatContainer.innerHTML = '';

  const wsUrl = 'ws://localhost:8080/';

  const socket = new WebSocket(wsUrl);
  const messageInput = document.getElementById('chat-type-field');
  const sendBtn = document.getElementById('send-button');

  console.log(weddingID);
  socket.onopen = async () => {
    weddingID.then(data => {
      handshake = JSON.stringify({
        weddingID: data
      })
      console.log('WebSocket connection opened. Sending wedding ID...');
      console.log(handshake);
      socket.send(handshake);
    })
  };

  socket.onmessage = (event) => {
    const messages = JSON.parse(event.data);
    console.log(messages);
    messages.forEach(message => {
      if (!message) {
        return;
      }
      const sender = (message.role === 'planner') ? 'me' : message.role;
      if (message.relativePath) {
        appendImageMessage(message.relativePath, message.timestamp, sender);
        return;
      } else {
        appendTextMessage(message.message, message.timestamp, sender);
      }
    });
  };

  socket.onerror = (error) => {
    console.error('WebSocket error:', error);
    chatContainer.innerHTML = "<p>Unexpected error occured</p>"
  };

  socket.onclose = () => {
    console.log('WebSocket connection closed.');
  };

  function appendTextMessage(message, timestamp, sender) {
    const messageElement = document.createElement('div');
    messageElement.classList.add('message');
    messageElement.innerHTML = `<div class="sender ${sender}">` + sender + ': </div><p class=message-text>' + message + '</p>';
    messageElement.dataset.timestamp = timestamp;
    chatContainer.appendChild(messageElement);
  }
  function appendImageMessage(imageReference, timestamp, sender) {
    const imageElement = document.createElement('div');
    imageElement.classList.add('message', 'image');
    imageElement.dataset.timestamp = timestamp;
    imageElement.style.display = 'flex';
    imageElement.style.flexDirection = 'column';

    const senderElement = document.createElement('div');
    senderElement.classList.add(sender);
    senderElement.classList.add('sender');
    senderElement.innerHTML = '<h4">' + sender + '</h4>';
    imageElement.appendChild(senderElement);
    const img = document.createElement('img');
    img.src = "http://cdn.blissfulbeginnings.com" + imageReference;
    img.alt = "Uploaded Image";
    img.classList.add('chat-image');

    imageElement.appendChild(img);
    chatContainer.appendChild(imageElement);
  }


  sendBtn.addEventListener('click', () => {
    timestamp = new Date().toISOString()
    timestamp = timestamp.replace('T', ' ').split('.')[0];
    const message = messageInput.value.trim();
    if (message) {
      chatMessage = {
        role: 'planner',
        message: message,
        timestamp: timestamp,
      };
      socket.send(JSON.stringify(chatMessage));
      console.log(chatMessage);
      appendTextMessage(message, timestamp, 'me');
      messageInput.value = '';
      chatContainer.scrollTop = chatContainer.scrollHeight;
    }
  });

  messageInput.addEventListener('keypress', (event) => {
    if (event.key === 'Enter') {
      sendBtn.click();
    }
  });


  document.getElementById('imageUpload').addEventListener('change', async function (event) {
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


    timestamp = new Date().toISOString()
    timestamp = timestamp.replace('T', ' ').split('.')[0];
    sender = "planner"
    const formData = new FormData();
    formData.append("image", file);
    formData.append("timestamp", timestamp);
    formData.append("sender", JSON.stringify(sender));

    try {
      weddingID.then(
        async _data => {
          const response = await fetch("/chat/upload-image/" + _data, {
            method: "POST",
            body: formData,
          });

          if (!response.ok) {
            throw new Error(`Failed to upload image. Status: ${response.status}`);
          }

          const data = await response.json();

          if (!data.storagePath) {
            throw new Error("Invalid response from server. No storage path provided.");
          }

          const imageReference = data.storagePath;

          const metaWithImage = {
            timestamp: formData.timestamp,
            role: "Vendor",
            relativePath: imageReference,
            Image: "image_reference",
          };

          socket.send(JSON.stringify(metaWithImage));

          appendImageMessage(imageReference, metaWithImage.timestamp, metaWithImage.sender);
          alert("Image sent successfully!");
        }
      )

    } catch (error) {
      console.error("Error:", error);
      alert("An error occurred while uploading the image.");
    }
  });

  chatContainer.scrollTop = chatContainer.scrollHeight;
}
document.addEventListener("DOMContentLoaded", renderMessages);

document.addEventListener("DOMContentLoaded", render);
