'use strict';

const webSocketPort = wsPort ? wsPort : 8080;
const conn = new WebSocket('ws://localhost:' + webSocketPort);
const user = userName;
const avatar = userAvatar;
const domain = urlApi;

conn.onopen = () => {
  console.log("Connection established!");
};

conn.onerror = () => {
  console.log("Connection failed!");
};

(($) => {
  $(() => {

    /* Creates a list of projects for output in the options */
    const $chatTitleSelect = $('#chatTitle');
    fetch(`${domain}`)
      .then((response) => response.json())
      .then(result =>{
        result.map((item) => {
          const $option = $('<option />', {
            text: item.title,
          });
          $chatTitleSelect.append($option);
        })
      })
      .catch(() => {
        console.log('error');
      });

    /**
     * Sens message when an 'onclick' event occurs
     */
    $('#chatSubmit').on('click', () => {
      const $title = $('#chatTitle');
      const $elem = $('#bodyMessage');
      const title = $title.val();
      const elemText = $elem.val();

      conn.send(`${user}::${title}::${elemText}::${avatar}`);
      $title.val('');
      $elem.val('');
    });

    /**
     * Receives message and places it into DOM-elements
     * @param e
     */
    conn.onmessage = (e) => {
      const data = e.data.split(/::/);

      const chat = new ChatBox(data);
      chat.addMessageToBox();
      chat.addMessageToDropdownBox();
    };

     /**
     * Class for creating message containers
     */
    class ChatBox {
       constructor([senderId, senderName, title, message, image, receiverId]) {
         this.senderId = senderId;
         this.senderName = senderName;
         this.title = title;
         this.message = message;
         this.image = image;
         this.receiverId = receiverId;
       }

       /**
        * Adds received message to all messages container
        */
       addMessageToBox() {
         const $allMessagesBox = $('#allMessages');
         const $chatBox = $(`ul#chatMessages_${this.title}`);
         if ($chatBox.length !== 0) {
           const $oneMessage = $('<li />', {
             class: 'oneMessage',
             text: `User ${this.senderName}:  ${this.message}`,
           });
           $chatBox.prepend($oneMessage);
         } else {
           const $title = $('<h5 />', {
             text: `Thread: project ${this.title}`
           });
           const $chatBox = $('<ul />', {
             class: 'chatMessages',
             id: `chatMessages_${this.title}`,
           });
           $allMessagesBox.append($title).append($chatBox);
           const $oneMessage = $('<li />', {
             class: 'oneMessage',
             text: `User ${this.senderName}:  ${this.message}`,
           });
           $chatBox.prepend($oneMessage);
         }
       }
     }
  });
})(jQuery);



