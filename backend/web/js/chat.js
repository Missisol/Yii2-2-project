'use strict';

const webSocketPort = wsPort ? wsPort : 8080;
const conn = new WebSocket('ws://localhost:' + webSocketPort);
const user = userName;

conn.onopen = (e) => {
  console.log("Connection established!");
};

conn.onerror = (e) => {
  console.log("Connection failed!");
};

(($) => {
  $(() => {
    /**
     * Sens message when an 'onclick' event occurs
     */
    $('#chatSubmit').on('click', () => {
      const $elem = $('#bodyMessage');
      const elemText = $elem.val();

      conn.send(`${userName}::${elemText}`);
      $elem.val('');
    });

    /**
     * Receives message and places it into DOM-elements
     * @param e
     */
    conn.onmessage = (e) => {
      console.log(e.data);
      const data = e.data.split(/::/);
      const senderId = data[0];
      const senderName = data[1];
      const message = data[2];
      const receiverId = data[3];

      const chat = new ChatBox(senderId, senderName, message, receiverId);
      chat.addMessageToBox();
      chat.addMessageToDropdownBox();
    };

     /**
     * Class for creating message containers
     */
    class ChatBox {
      constructor(senderId, senderName, message, receiverId) {
        this.senderId = senderId;
        this.senderName = senderName;
        this.message = message;
        this.receiverId = receiverId;
      }

      /**
       * Adds received message to all messages container
       */
      addMessageToBox() {
        const $chatBox = $('#chatMessages');
        const $oneMessage = $('<li />', {
          class: 'oneMessage',
          text: `User ${this.senderName}:  ${this.message}`,
        });
        $chatBox.prepend($oneMessage);
      }

      /**
       * Adds received message to dropdown container
       */
      addMessageToDropdownBox() {
        if (this.senderId !== this.receiverId) {
          const $li = $('<li />');
          const $a = $('<a />', {href: '#'});
          const $div = $('<div />', {class: 'pull-left'});
          const $img = $('<img />', {
            src: `/assets/29af8489/img/${this.senderName}.jpg`,
            class: 'img-circle',
            alt: 'User Image',
          });
          $div.append($img);
          const $h4 = $('<h4 />').text(`nickname: ${this.senderName}`);
          const $small = $('<small />');
          const $i = $('<i />', {class: 'fa fa-clock-o'});
          $small.append($i).append(new Date().toLocaleString('ru', {
            day: 'numeric',
            month: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
          }));
          $h4.append($small);
          const $p = $('<p />', {class: 'messageText'}).text(this.message);
          $a.append($div).append($h4).append($p);
          $li.append($a);
          $('ul.menu').prepend($li);

          const cnt = $('li.messages-menu ul.menu li').length;
          $('li.messages-menu span.label-success').text(cnt);
          $('li.messages-menu li.header').text(`You have ${cnt} messages`);
        }
      }
    }
  });
})(jQuery);



