<!-- resources/views/components/mic-and-speak.blade.php
@props(['disabled' => false])

<style>
    /* Styles for modal and buttons */
    .mini-modal {
        display: none;
        position: absolute;
        z-index: 1;
        padding: 10px;
        background-color: #fefefe;
        border: 1px solid #888;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 200px;
    }

    .mini-modal-content {
        background-color: #fefefe;
        padding: 10px;
        border-radius: 4px;
    }

    .mini-modal-content h2 {
        font-size: 16px;
        margin-top: 0;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
    }

    .mic-btn,
    .speak-btn {
        background: none;
        border: none;
        outline: none;
        cursor: pointer;
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        box-shadow: none;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .mic-btn i,
    .speak-btn i {
        color: black;
    }

    .mic-btn:focus,
    .mic-btn:hover,
    .mic-btn:active,
    .speak-btn:focus,
    .speak-btn:hover,
    .speak-btn:active {
        box-shadow: none;
    }

    .relative-container {
        position: relative;
    }

    .relative-container textarea,
    .relative-container input {
        width: 100%;
        padding-right: 40px;
    }

    .relative-container:hover .mic-btn {
        opacity: 1;
    }

    .relative-container:hover .speak-btn {
        opacity: 1;
    }

    .mic-btn {
        right: 50px;
    }

    .speak-btn {
        right: 16px;
    }

    .disabled {
        pointer-events: none;
        opacity: 0.5;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<button class="mic-btn" type="button" style="display: none;" {{ $disabled ? 'disabled' : '' }}>
    <i class="fas fa-microphone"></i>
</button>
<button class="speak-btn" type="button" {{ $disabled ? 'disabled' : '' }}>
    <i class="fas fa-volume-up"></i>
</button>
<div class="mini-modal">
    <div class="mini-modal-content">
        <span class="close">&times;</span>
        <h2>Select Language</h2>
        <select id="language-select">
            <option value="en-us">English</option>
            <option value="hi-in">Hindi</option>
            <option value="te-in">Telugu</option>
            <option value="fr-fr">French</option>
            <option value="es-es">Spanish</option>
            <option value="zh-cn">Chinese (Mandarin)</option>
            <option value="ja-jp">Japanese</option>
            <option value="de-de">German</option>
            <option value="ru-ru">Russian</option>
            <option value="ko-kr">Korean</option>
            <option value="it-it">Italian</option>
            <option value="pt-br">Portuguese (Brazil)</option>
            <option value="ar-sa">Arabic</option>
            <option value="bn-in">Bengali</option>
            <option value="pa-in">Punjabi</option>
            <option value="mr-in">Marathi</option>
            <option value="gu-in">Gujarati</option>
            <option value="ur-pk">Urdu</option>
            <option value="ta-in">Tamil</option>
            <option value="kn-in">Kannada</option>
            <option value="ml-in">Malayalam</option>
            <option value="or-in">Odia</option>
            <option value="as-in">Assamese</option>
        </select>
        <button id="select-language-btn">Select</button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        let audio = null;
        let selectedLanguage = 'en-us'; // Default language
        let isPlaying = false; // Flag to check if audio is playing
        let isRecognizing = false; // Flag to check if speech recognition is active
        let pendingTextToSpeak = ''; // Store text that needs to be spoken

        // Function to disable all relevant buttons
        function disableButtons() {
            $('.mic-btn, .speak-btn').addClass('disabled');
        }

        // Function to enable all relevant buttons
        function enableButtons() {
            $('.mic-btn, .speak-btn').removeClass('disabled');
        }

        // When the user clicks the button, open the mini modal
        $(document).on('click', '.speak-btn', function() {
            let inputField = $(this).siblings('textarea, input');
            let textToSpeak = inputField.val();
            let modal = $(this).siblings('.mini-modal');
            if (textToSpeak) {
                // Store the input field element and text
                $(modal).data('inputField', inputField);
                $(modal).data('textToSpeak', textToSpeak);
                modal.css({
                    display: 'block',
                    top: $(this).position().top - modal.outerHeight() - 10,
                    left: $(this).position().left + $(this).outerWidth() - modal.outerWidth()
                });
            }
        });

        // When the user clicks on <span> (x), close the mini modal
        $(document).on('click', '.close', function() {
            $(this).closest('.mini-modal').css('display', 'none');
        });

        // When the user selects a language and clicks the button
        $(document).on('click', '#select-language-btn', function(event) {
            event.preventDefault(); // Prevent form submission
            let modal = $(this).closest('.mini-modal');
            selectedLanguage = modal.find('#language-select').val();
            let textToSpeak = $(modal).data('textToSpeak');

            if (textToSpeak && !isPlaying && !isRecognizing) { // Play only if not already playing or recognizing
                isPlaying = true; // Set flag to true to indicate audio is playing
                disableButtons(); // Disable buttons

                if (audio) {
                    audio.pause();
                    audio.currentTime = 0;
                }

                const apiKey = '2eb46647591a4b0596c383e9b8aeb58c';
                const url =
                    `https://api.voicerss.org/?key=${apiKey}&hl=${selectedLanguage}&src=${encodeURIComponent(textToSpeak)}&r=0&c=WAV&f=44khz_16bit_stereo`;
                audio = new Audio(url);
                audio.play();

                audio.onended = function() {
                    isPlaying = false; // Reset flag when audio ends
                    audio = null;
                    enableButtons(); // Enable buttons
                };

                audio.onerror = function() {
                    console.error('Error playing audio');
                    isPlaying = false; // Reset flag on error
                    audio = null;
                    enableButtons(); // Enable buttons
                };
            }

            modal.css('display', 'none');
        });

        // Speech-to-Text functionality
        const recognition = new(window.SpeechRecognition || window.webkitSpeechRecognition)();
        recognition.continuous = false;
        recognition.interimResults = false;
        recognition.lang = 'en-US';

        function startRecognition(targetElement) {
            if (!isRecognizing) {
                isRecognizing = true;
                disableButtons(); // Disable buttons during recognition
                recognition.start();
                recognition.onresult = function(event) {
                    const transcript = event.results[0][0].transcript;
                    targetElement.value += transcript;
                    isRecognizing = false;
                    enableButtons(); // Enable buttons after recognition

                    // Trigger TTS playback if there was text to speak
                    if (targetElement.value.trim() !== '') {
                        $('.speak-btn').trigger('click');
                    }
                };
                recognition.onerror = function(event) {
                    console.error(event.error);
                    isRecognizing = false;
                    enableButtons(); // Enable buttons on error
                };
                recognition.onend = function() {
                    isRecognizing = false;
                    enableButtons(); // Enable buttons when recognition ends
                };
            }
        }

        $(document).on('click', '.mic-btn', function() {
            const inputField = $(this).siblings('textarea, input');
            startRecognition(inputField[0]);
        });

        // Show mic button on hover
        $('.relative-container').hover(
            function() {
                $(this).find('.mic-btn').show();
            },
            function() {
                $(this).find('.mic-btn').hide();
            }
        );
    });
</script> -->






<!-- language_modal_file -->

<div class="mini-modal">
    <div class="mini-modal-content">
        <span class="close">&times;</span>
        <h2>Select Language</h2>
        <select id="language-select">
            <option value="en-us">English</option>
            <option value="hi-in">Hindi</option>
            <option value="te-in">Telugu</option>
            <option value="fr-fr">French</option>
            <option value="es-es">Spanish</option>
            <option value="zh-cn">Chinese (Mandarin)</option>
            <option value="ja-jp">Japanese</option>
            <option value="de-de">German</option>
            <option value="ru-ru">Russian</option>
            <option value="ko-kr">Korean</option>
            <option value="it-it">Italian</option>
            <option value="pt-br">Portuguese (Brazil)</option>
            <option value="ar-sa">Arabic</option>
            <option value="bn-in">Bengali</option>
            <option value="pa-in">Punjabi</option>
            <option value="mr-in">Marathi</option>
            <option value="gu-in">Gujarati</option>
            <option value="ur-pk">Urdu</option>
            <option value="ta-in">Tamil</option>
            <option value="kn-in">Kannada</option>
            <option value="ml-in">Malayalam</option>
            <option value="or-in">Odia</option>
            <option value="as-in">Assamese</option>
        </select>
        <button id="select-language-btn">Select</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize speech recognition
        const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
        recognition.continuous = false;
        recognition.interimResults = false;
        recognition.lang = 'en-US';

        // Function to start speech recognition and append result to the target element
        function startRecognition(targetElement) {
            recognition.start();
            recognition.onresult = function(event) {
                const transcript = event.results[0][0].transcript;
                targetElement.value += transcript;
            };
            recognition.onerror = function(event) {
                console.error(event.error);
            };
        }

        // Event delegation for all mic buttons
        document.addEventListener('click', function(event) {
            const button = event.target.closest('.mic-btn');
            if (button) {
                const inputField = button.previousElementSibling;
                if (inputField && inputField.classList.contains('mic-input')) {
                    startRecognition(inputField);
                }
                return;
            }
        });

        // Show/hide mic button on focus/blur of input fields
        const micInputs = document.querySelectorAll('.mic-input');
        micInputs.forEach(input => {
            input.addEventListener('focus', function() {
                const micBtn = this.nextElementSibling;
                if (micBtn && micBtn.classList.contains('mic-btn')) {
                    micBtn.style.display = 'block';
                }
            });
            input.addEventListener('blur', function(event) {
                const micBtn = this.nextElementSibling;
                if (micBtn && micBtn.classList.contains('mic-btn')) {
                    // Use a timeout to prevent immediate hiding when the button is clicked
                    setTimeout(() => {
                        if (!event.relatedTarget || !event.relatedTarget.classList.contains('mic-btn')) {
                            micBtn.style.display = 'none';
                        }
                    }, 200);
                }
            });
        });
    });

    // Show/hide the container based on user selection
    function toggleOthersField(selectedValue) {
        const container = document.getElementById('external_agencies_req');
        if (selectedValue === 'others') {
            container.classList.remove('d-none');
        } else {
            container.classList.add('d-none');
        }
    }
</script>
<!-- <script>
$(document).ready(function() {
    let audio = null;
    let selectedLanguage = 'en-US'; // Default language
    let inputText = '';

    // When the user clicks the button, open the mini modal 
    $(document).on('click', '.speak-btn', function() {
        let inputField = $(this).siblings('textarea, input');
        inputText = inputField.val();
        let modal = $(this).siblings('.mini-modal');
        if (inputText) {
            // Store the input field element
            $(modal).data('inputField', inputField);
            modal.css({
                display: 'block',
                top: $(this).position().top - modal.outerHeight() - 10,
                left: $(this).position().left + $(this).outerWidth() - modal.outerWidth()
            });
        }
    });

    // When the user clicks on <span> (x), close the mini modal
    $(document).on('click', '.close', function() {
        $(this).closest('.mini-modal').css('display', 'none');
    });

    // When the user selects a language and clicks the button
    $(document).on('click', '#select-language-btn', function(event) {
        event.preventDefault(); // Prevent form submission
        let modal = $(this).closest('.mini-modal');
        selectedLanguage = modal.find('#language-select').val(); // Get selected language
        let inputField = modal.data('inputField');
        let textToSpeak = inputText;

        if (textToSpeak) {
            if (audio) {
                audio.pause();
                audio.currentTime = 0;
            }

            // Translate the text before converting to speech
            translateText(textToSpeak, selectedLanguage.split('-')[0]).then(translatedText => {
                const utterance = new SpeechSynthesisUtterance(translatedText);
                utterance.lang = selectedLanguage; // Set the language for speech synthesis
                speechSynthesis.speak(utterance); // Speak the translated text

                utterance.onend = function() {
                    audio = null;
                };
            }).catch(error => {
                console.error('Translation failed: ', error);
            });
        }

        modal.css('display', 'none');
    });

    // Speech-to-Text functionality
    const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
    recognition.continuous = false;
    recognition.interimResults = false;
    recognition.lang = 'en-US';

    function startRecognition(targetElement) {
        recognition.start();
        recognition.onresult = function(event) {
            const transcript = event.results[0][0].transcript;
            targetElement.value += transcript;
        };
        recognition.onerror = function(event) {
            console.error(event.error);
        };
    }

    $(document).on('click', '.mic-btn', function() {
        const inputField = $(this).siblings('textarea, input');
        startRecognition(inputField[0]);
    });

    // Show mic button on hover
    $('.relative-container').hover(
        function() {
            $(this).find('.mic-btn').show();
        },
        function() {
            $(this).find('.mic-btn').hide();
        }
    );

    // Function to translate text using RapidAPI
    async function translateText(text, targetLanguage) {
        const url = 'https://google-translator9.p.rapidapi.com/v2/detect';
        const data = {
            q: text,
            target: targetLanguage
        };

        const options = {
                method: 'POST',
                headers: {
                    'x-rapidapi-key': 'd7f1a50be2msh0efa8fb25946327p1168c9jsn57137a2a1ebe',
                    'x-rapidapi-host': 'google-translator9.p.rapidapi.com',
                    'Content-Type': 'application/json'
                },
            body: new URLSearchParams(data)
        };

        try {
            const response = await fetch(url, options);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const result = await response.json();
            return result.data.translations[0].translatedText;
        } catch (error) {
            console.error('Error occurred:', error);
        }
    }

    // Update remaining characters
    $('#docname').on('input', function() {
        const remaining = 255 - $(this).val().length;
        $('#rchars').text(remaining);
    });

    // Initialize remaining characters count
    const remaining = 255 - $('#docname').val().length;
    $('#rchars').text(remaining);
});
</script> -->

<script>
$(document).ready(function() {
    let audio = null;
    let selectedLanguage = 'en-US'; // Default language
    let inputText = '';

    // When the user clicks the button, open the mini modal 
    $(document).on('click', '.speak-btn', function() {
        let inputField = $(this).siblings('textarea, input');
        inputText = inputField.val();
        let modal = $(this).siblings('.mini-modal');
        if (inputText) {
            // Store the input field element
            $(modal).data('inputField', inputField);
            modal.css({
                display: 'block',
                top: $(this).position().top - modal.outerHeight() - 10,
                left: $(this).position().left + $(this).outerWidth() - modal.outerWidth()
            });
        }
    });

    // When the user clicks on <span> (x), close the mini modal
    $(document).on('click', '.close', function() {
        $(this).closest('.mini-modal').css('display', 'none');
    });

    // When the user selects a language and clicks the button
    $(document).on('click', '#select-language-btn', function(event) {
        event.preventDefault(); // Prevent form submission
        let modal = $(this).closest('.mini-modal');
        selectedLanguage = modal.find('#language-select').val(); // Get selected language
        let inputField = modal.data('inputField');
        let textToSpeak = inputText;

        if (textToSpeak) {
            if (audio) {
                audio.pause();
                audio.currentTime = 0;
            }

            // Translate the text before converting to speech
            translateText(textToSpeak, selectedLanguage.split('-')[0]).then(translatedText => {
                if (translatedText) {
                    const utterance = new SpeechSynthesisUtterance(translatedText);
                    utterance.lang = selectedLanguage; // Set the language for speech synthesis
                    speechSynthesis.speak(utterance); // Speak the translated text

                    utterance.onend = function() {
                        audio = null;
                    };
                } else {
                    console.error('Translation failed: No translated text found.');
                }
            }).catch(error => {
                console.error('Translation failed: ', error);
            });
        }

        modal.css('display', 'none');
    });

    // Speech-to-Text functionality
    const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
    recognition.continuous = false;
    recognition.interimResults = false;
    recognition.lang = 'en-US';

    function startRecognition(targetElement) {
        recognition.start();
        recognition.onresult = function(event) {
            const transcript = event.results[0][0].transcript;
            targetElement.value += transcript;
        };
        recognition.onerror = function(event) {
            console.error(event.error);
        };
    }

    $(document).on('click', '.mic-btn', function() {
        const inputField = $(this).siblings('textarea, input');
        startRecognition(inputField[0]);
    });

    // Show mic button on hover
    $('.relative-container').hover(
        function() {
            $(this).find('.mic-btn').show();
        },
        function() {
            $(this).find('.mic-btn').hide();
        }
    );

    // Function to translate text using RapidAPI (correct endpoint and error logging)
    async function translateText(text, targetLanguage) {
        const url = 'https://google-translator9.p.rapidapi.com/v2/translate'; // Correct endpoint
        const data = {
            q: text,
            target: targetLanguage
        };

        const options = {
            method: 'POST',
            headers: {
                'x-rapidapi-key': 'd7f1a50be2msh0efa8fb25946327p1168c9jsn57137a2a1ebe',
                'x-rapidapi-host': 'google-translator9.p.rapidapi.com',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data) // Send JSON data
        };

        try {
            const response = await fetch(url, options);
            const result = await response.json();
            
            // Log the entire response for debugging
            console.log('API Response:', result);

            // Defensive check to ensure data exists and is structured correctly
            if (result.data && result.data.translations && result.data.translations[0]) {
                return result.data.translations[0].translatedText;
            } else if (result.error) {
                console.error('API Error:', result.error);
                return null;
            } else {
                console.error('Translation data is missing or incomplete.');
                return null;
            }
        } catch (error) {
            console.error('Error occurred:', error);
        }
    }

    // Update remaining characters
    $('#docname').on('input', function() {
        const remaining = 255 - $(this).val().length;
        $('#rchars').text(remaining);
    });

    // Initialize remaining characters count
    const remaining = 255 - $('#docname').val().length;
    $('#rchars').text(remaining);
});
</script>







<!-- Ensure this CSS is present to initially hide the Others field and its group -->
<style>
    #others_group {
        display: none;
    }
</style>

<style>
        .group-input {
            margin-bottom: 20px;
        }
        .mic-btn, .speak-btn {
            background: none;
            border: none;
            outline: none;
            cursor: pointer;
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            box-shadow: none;
        }
        .mic-btn i, .speak-btn i {
            color: black;
        }
        .mic-btn:focus,
        .mic-btn:hover,
        .mic-btn:active,
        .speak-btn:focus,
        .speak-btn:hover,
        .speak-btn:active {
            box-shadow: none;
        }
        .relative-container {
            position: relative;
        }
        .relative-container input {
            width: 100%;
            padding-right: 40px;
        }
    </style>

    <style>
    #start-record-btn {
        background: none;
        border: none;
        outline: none;
        cursor: pointer;
    }
    #start-record-btn i {
        color: black; /* Set the color of the icon */
        box-shadow: none; /* Remove shadow */
    }
    #start-record-btn:focus,
    #start-record-btn:hover,
    #start-record-btn:active {
        box-shadow: none; /* Remove shadow on hover/focus/active */
    }
</style>
<style>
    .mic-btn {
        background: none;
        border: none;
        outline: none;
        cursor: pointer;
        position: absolute;
        right: 10px; /* Position the button at the right corner */
        top: 50%; /* Center the button vertically */
        transform: translateY(-50%); /* Adjust for the button's height */
        box-shadow: none;
         /* Remove shadow */
    }
    .mic-btn {
            right: 50px; /* Adjust position to avoid overlap with speaker button */
        }

        .speak-btn {
            right: 16px;
        }
    .mic-btn i {
        color: black; /* Set the color of the icon */
        // box-shadow: none; /* Remove shadow */
    }
    .mic-btn:focus,
    .mic-btn:hover,
    .mic-btn:active {
        box-shadow: none; /* Remove shadow on hover/focus/active */
        // display: none;
    }

    .relative-container {
        position: relative;
    }

    .relative-container textarea {
        width: 100%;
        padding-right: 40px; /* Ensure the text does not overlap the button */
    }
</style>
<style>
          .mini-modal {
            display: none;
            position: absolute;
            z-index: 1;
            padding: 10px;
            background-color: #fefefe;
            border: 1px solid #888;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 200px; /* Adjust width as needed */
        }
        .mini-modal-content {
            background-color: #fefefe;
            padding: 10px;
            border-radius: 4px;
        }
        .mini-modal-content h2 {
            font-size: 16px;
            margin-top: 0;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }
        button {
    border: 0;
    background: white;
    color: #060606;
    /* border: 2px solid black; */
    transition: all 0.3s linear;
}

button:hover {
    color: #0c0c0c;
}
    </style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize speech recognition
        const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
        recognition.continuous = false;
        recognition.interimResults = false;
        recognition.lang = 'en-US';

        // Function to start speech recognition and append result to the target element
        function startRecognition(targetElement) {
            recognition.start();
            recognition.onresult = function(event) {
                const transcript = event.results[0][0].transcript;
                targetElement.value += transcript;
            };
            recognition.onerror = function(event) {
                console.error(event.error);
            };
        }

        // Event delegation for all mic buttons
        document.addEventListener('click', function(event) {
            if (event.target.closest('.mic-btn')) {
                const button = event.target.closest('.mic-btn');
                const inputField = button.previousElementSibling;
                if (inputField && inputField.classList.contains('mic-input')) {
                    startRecognition(inputField);
                }
            }
        });
    });

    // Show/hide the container based on user selection
    function toggleOthersField(selectedValue) {
        const container = document.getElementById('external_agencies_req');
        if (selectedValue === 'others') {
            container.classList.remove('d-none');
        } else {
            container.classList.add('d-none');
        }
    }
</script>

<style>
    .mic-btn {
        background: none;
        border: none;
        outline: none;
        cursor: pointer;
        position: absolute;
        right: 10px; /* Position the button at the right corner */
        top: 50%; /* Center the button vertically */
        transform: translateY(-50%); /* Adjust for the button's height */
        box-shadow: none; /* Remove shadow */
    }
    .mic-btn i {
        color: black; /* Set the color of the icon */
        box-shadow: none; /* Remove shadow */
    }
    .mic-btn:focus,
    .mic-btn:hover,
    .mic-btn:active {
        box-shadow: none; /* Remove shadow on hover/focus/active */
    }

    .relative-container {
        position: relative;
    }

    .relative-container textarea {
        width: 100%;
        padding-right: 40px; /* Ensure the text does not overlap the button */
    }
</style>

    <style>
    #start-record-btn {
        background: none;
        border: none;
        outline: none;
        cursor: pointer;
    }
    #start-record-btn i {
        color: black; /* Set the color of the icon */
        box-shadow: none; /* Remove shadow */
    }
    #start-record-btn:focus,
    #start-record-btn:hover,
    #start-record-btn:active {
        box-shadow: none; /* Remove shadow on hover/focus/active */
    }
</style>


<style>
    .mic-btn {
        background: none;
        border: none;
        outline: none;
        cursor: pointer;
        position: absolute;
        right: 10px; /* Position the button at the right corner */
        top: 50%; /* Center the button vertically */
        transform: translateY(-50%); /* Adjust for the button's height */
        box-shadow: none; /* Remove shadow */
    }
    .mic-btn i {
        color: black; /* Set the color of the icon */
        box-shadow: none; /* Remove shadow */
    }
    .mic-btn:focus,
    .mic-btn:hover,
    .mic-btn:active {
        box-shadow: none; /* Remove shadow on hover/focus/active */
    }

    .relative-container {
        position: relative;
    }

    .relative-container textarea {
        width: 100%;
        padding-right: 40px; /* Ensure the text does not overlap the button */
    }
</style>

<!-- Ensure this CSS is present to initially hide the Others field and its group -->
<style>
    #others_group {
        display: none;
    }
</style>

<style>
        .group-input {
            margin-bottom: 20px;
        }
        .mic-btn, .speak-btn {
            background: none;
            border: none;
            outline: none;
            cursor: pointer;
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            box-shadow: none;
        }
        .mic-btn i, .speak-btn i {
            color: black;
        }
        .mic-btn:focus,
        .mic-btn:hover,
        .mic-btn:active,
        .speak-btn:focus,
        .speak-btn:hover,
        .speak-btn:active {
            box-shadow: none;
        }
        .relative-container {
            position: relative;
        }
        .relative-container input {
            width: 100%;
            padding-right: 40px;
        }
    </style>

    <style>
    #start-record-btn {
        background: none;
        border: none;
        outline: none;
        cursor: pointer;
    }
    #start-record-btn i {
        color: black; /* Set the color of the icon */
        box-shadow: none; /* Remove shadow */
    }
    #start-record-btn:focus,
    #start-record-btn:hover,
    #start-record-btn:active {
        box-shadow: none; /* Remove shadow on hover/focus/active */
    }
</style>
<style>
    .mic-btn {
        background: none;
        border: none;
        outline: none;
        cursor: pointer;
        position: absolute;
        right: 10px; /* Position the button at the right corner */
        top: 50%; /* Center the button vertically */
        transform: translateY(-50%); /* Adjust for the button's height */
        box-shadow: none;
         /* Remove shadow */
    }
    .mic-btn {
            right: 50px; /* Adjust position to avoid overlap with speaker button */
        }

        .speak-btn {
            right: 16px;
        }
    .mic-btn i {
        color: black; /* Set the color of the icon */
        // box-shadow: none; /* Remove shadow */
    }
    .mic-btn:focus,
    .mic-btn:hover,
    .mic-btn:active {
        box-shadow: none; /* Remove shadow on hover/focus/active */
        // display: none;
    }

    .relative-container {
        position: relative;
    }

    .relative-container textarea {
        width: 100%;
        padding-right: 40px; /* Ensure the text does not overlap the button */
    }
</style>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize speech recognition
        const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
        recognition.continuous = false;
        recognition.interimResults = false;
        recognition.lang = 'en-US';

        // Function to start speech recognition and append result to the target element
        function startRecognition(targetElement) {
            recognition.start();
            recognition.onresult = function(event) {
                const transcript = event.results[0][0].transcript;
                targetElement.value += transcript;
            };
            recognition.onerror = function(event) {
                console.error(event.error);
            };
        }

        // Event delegation for all mic buttons
        document.addEventListener('click', function(event) {
            if (event.target.closest('.mic-btn')) {
                const button = event.target.closest('.mic-btn');
                const inputField = button.previousElementSibling;
                if (inputField && inputField.classList.contains('mic-input')) {
                    startRecognition(inputField);
                }
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize speech recognition
        const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
        recognition.continuous = false;
        recognition.interimResults = false;
        recognition.lang = 'en-US';

        // Function to start speech recognition and append result to the target element
        function startRecognition(targetElement) {
            recognition.start();
            recognition.onresult = function(event) {
                const transcript = event.results[0][0].transcript;
                targetElement.value += transcript;
            };
            recognition.onerror = function(event) {
                console.error(event.error);
            };
        }

        // Event delegation for all mic buttons
        document.addEventListener('click', function(event) {
            if (event.target.closest('.mic-btn')) {
                const button = event.target.closest('.mic-btn');
                const inputField = button.previousElementSibling;
                if (inputField && inputField.classList.contains('mic-input')) {
                    startRecognition(inputField);
                }
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize speech recognition
        const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
        recognition.continuous = false;
        recognition.interimResults = false;
        recognition.lang = 'en-US';

        // Function to start speech recognition and append result to the target element
        function startRecognition(targetElement) {
            recognition.start();
            recognition.onresult = function(event) {
                const transcript = event.results[0][0].transcript;
                targetElement.value += transcript;
            };
            recognition.onerror = function(event) {
                console.error(event.error);
            };
        }

        // Event delegation for all mic buttons
        document.addEventListener('click', function(event) {
            const button = event.target.closest('.mic-btn');
            if (button) {
                const inputField = button.previousElementSibling;
                if (inputField && inputField.classList.contains('mic-input')) {
                    startRecognition(inputField);
                }
                return;
            }
        });

        // Show/hide mic button on focus/blur of input fields
        const micInputs = document.querySelectorAll('.mic-input');
        micInputs.forEach(input => {
            input.addEventListener('focus', function() {
                const micBtn = this.nextElementSibling;
                if (micBtn && micBtn.classList.contains('mic-btn')) {
                    micBtn.style.display = 'block';
                }
            });
            input.addEventListener('blur', function(event) {
                const micBtn = this.nextElementSibling;
                if (micBtn && micBtn.classList.contains('mic-btn')) {
                    // Use a timeout to prevent immediate hiding when the button is clicked
                    setTimeout(() => {
                        if (!event.relatedTarget || !event.relatedTarget.classList.contains('mic-btn')) {
                            micBtn.style.display = 'none';
                        }
                    }, 200);
                }
            });
        });
    });

    // Show/hide the container based on user selection
    function toggleOthersField(selectedValue) {
        const container = document.getElementById('external_agencies_req');
        if (selectedValue === 'others') {
            container.classList.remove('d-none');
        } else {
            container.classList.add('d-none');
        }
    }
</script>





