;(function() {

    let formData = new FormData();
    formData.append('OFFSET', '0');

    let xhr = new XMLHttpRequest();
    xhr.open('post', '/chat/getHistory');
    xhr.send(formData);
    xhr.onreadystatechange = () => {
        if (xhr.readyState === 4) {
            console.log(xhr.responseText);
        }
    }


    $(document).on('click', '.message-send', (e) => {

        let message = document.querySelector('.message-input').value;

        if (message.length === 0) {
            return false;
        }

        let formData = new FormData();
        formData.append('MESSAGE_TEXT', message);

        let xhr = new XMLHttpRequest();
        xhr.open('post', '/chat/send');
        xhr.send(formData);

        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4) {
                alert('Сообщение вышло на свет =))');
            }
        }

    });

    class Chat {
        constructor() {
        }

        getHistory()  {

        }
    }

    class Ajax {

        constructor() {
            this.xhr = new XMLHttpRequest();
            this.data = new FormData();
            this.method = '';
            this.url = '';
            this.eventNames = {};
        }

        setBody(formData) {
            this.data = formData;
        }

        bodyAdd(name, value) {
            this.data.append(name, value)
        }

        addEventName(eventName, callback) {
            this.eventNames.eventName = callback;
        }

        send(longpooling, timeout) {

            if (this.method.length === 0) {
                console.error('No set method');
                return false;
            }

            if (this.url.length === 0) {
                console.error('No set url');
                return false;
            }

            let xhr = new XMLHttpRequest();

            xhr.onreadystatechange = () => {
                if(xhr.readyState !== 0) {
                    xhr.abort();
                }
            }

            xhr.onreadystatechange = () => {
                if(xhr.readyState === 4) {
                    this.result = xhr.responseText;
                    return true;
                }
            }

            if(longpooling && timeout) {
                setTimeout(() => {
                   this.send(longpooling, timeout);
                }, timeout);
            }

        }
    }

})();