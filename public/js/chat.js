const msgerForm = get(".msger-inputarea");
const msgerInput = get(".msger-input");
const msgerChat = get(".msger-chat");
const PERSON_IMG = "https://image.flaticon.com/icons/svg/145/145867.svg";
const chatWith = get(".chatWith");
const chatStatus = get(".chatStatus");
const typing = get(".typing");
const chatId = window.location.pathname.substr(6);
let authUser;
let typingTimer = false;

window.onload = function() {
    axios
        .get("/auth/user")
        .then(resp => {
            authUser = resp.data.user;
        })
        .then(() => {
            getAuthUsers();
        })
        .then(() => {
            getMessages();
        })
        .then(() => {
            echo();
        })
        .catch(err => console.log(err));
};
msgerForm.addEventListener("submit", event => {
    event.preventDefault();

    const msgText = msgerInput.value;

    if (!msgText) return;

    // Aquí vamos a colocar código más adelante
    axios
        .post("/message/sent", {
            message: msgText,
            chat_id: chatId
        })
        .then(resp => {
            let data = resp.data;
            appendMessage(
                data.message.user.name,
                document.getElementById('chatImage').value,
                "right",
                data.message.content,
                formatDate(new Date(data.message.created_at))
            );
        })
        .catch(err => {
            console.log(err);
        });
    msgerInput.value = "";
});

/* GET */

function getAuthUsers() {
    axios
        .get(`/chat/${chatId}/get-users`)
        .then(resp => {
            let results = resp.data.users.filter(
                user => user.id != authUser.id
            );

            if (results.length > 0) {
                let i = 0;
                for (let user of results) {
                    chatWith.innerHTML =
                        i !== 0 ? chatWith.innerHTML + user.name : user.name;
                    i++;
                }
            }
        })
        .catch(err => console.error(err));
}

function getMessages() {
    axios
        .get(`/chat/${chatId}/get-messages`)
        .then(resp => {
            const messages = resp.data.messages;
            console.log(messages);
            if (messages.length > 0) {
                appendMessages(messages);
            }
        })
        .catch(err => console.log(err));
}

function appendMessage(name, img, side, text, date) {
    //   Simple solution for small apps
    console.log(img);

    const msgHTML = `
    <div class="msg ${side}-msg">
      <div class="msg-img" style="background-image: url(/storage/${img}), url(${PERSON_IMG})"></div>

      <div class="msg-bubble">
        <div class="msg-info">
          <div class="msg-info-name">${name}</div>
          <div class="msg-info-time">${date}</div>
        </div>

        <div class="msg-text">${text}</div>
      </div>
    </div>
  `;

    msgerChat.insertAdjacentHTML("beforeend", msgHTML);
    bottomScroll();
}

function sendTypingEvent() {
    typingTimer = true;
    Echo.join(`chat.${chatId}`).whisper("typing", msgerInput.value.length);
}

// ECHO
function echo() {
    Echo.join(`chat.${chatId}`)
        .listen("MessageEvent", resp => {
            let message = resp.message;
            if (message.user_id != authUser.id) {
                appendMessage(
                    message.user.name,
                    message.user.image,
                    "left",
                    message.content,
                    formatDate(new Date(message.created_at))
                );
            }
        })
        .here(users => {
            let result = users.filter(user => stateUser(user));
            if (result.length > 0) chatStatus.className = "chatStatus online";
        })
        .joining(user => {
            if (stateUser(user)) {
                chatStatus.className = "chatStatus online";
            }
        })
        .leaving(user => {
            if (stateUser(user)) {
                chatStatus.className = "chatStatus offline";
            }
        })
        .listenForWhisper("typing", messageLength => {
            if (messageLength > 0) typing.style.display = "";

            if (typingTimer) {
                clearTimeout(typingTimer);
            }

            typingTimer = setTimeout(() => {
                typing.style.display = "none";
            }, 2500);
        });
}

// Utils
function get(selector, root = document) {
    return root.querySelector(selector);
}

function formatDate(date) {
    const d = date.getDate();
    const mo = date.getMonth() + 1;
    const y = date.getFullYear();
    const h = "0" + date.getHours();
    const m = "0" + date.getMinutes();
    return `${d}/${mo}/${y} ${h.slice(-2)}:${m.slice(-2)}`;
}

function appendMessages(messages) {
    let side;

    messages.forEach(message => {
        side = message.user_id == authUser.id ? "right" : "left";
        appendMessage(
            message.user.name,
            message.user.image,
            side,
            message.content,
            formatDate(new Date(message.created_at))
        );
    });
}

function bottomScroll() {
    msgerChat.scrollTop = msgerChat.scrollHeight;
}

function stateUser(user) {
    return user.id != authUser.id;
}

