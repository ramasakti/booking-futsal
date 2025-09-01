<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>OCR Test - Simple Version</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .container {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 2px dashed #ddd;
            border-radius: 5px;
            background: white;
        }

        button {
            background: #28a745;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        button:hover {
            background: #218838;
        }

        button:disabled {
            background: #6c757d;
            cursor: not-allowed;
        }

        #progress {
            margin: 20px 0;
            padding: 15px;
            background: #e9ecef;
            border-radius: 5px;
            min-height: 20px;
            text-align: center;
        }

        #result {
            width: 100%;
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            background: white;
        }

        .loading {
            color: #007bff;
            font-weight: bold;
        }

        .error {
            color: #dc3545;
            font-weight: bold;
        }

        .success {
            color: #28a745;
            font-weight: bold;
        }

        .preview {
            max-width: 300px;
            max-height: 200px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>📄 OCR Document Scanner</h1>
        <p>Upload an image to extract text using Tesseract.js</p>

        <form id="ocrForm">
            <div class="form-group">
                <label for="imageInput">Select Image:</label>
                <input type="file" id="imageInput" accept="image/*">
                <img id="preview" class="preview" style="display: none;" alt="Preview">
            </div>

            <button type="button" id="scanButton" onclick="processOCR()">
                🔍 Scan Text
            </button>

            <div id="progress">Ready to scan... Select an image first.</div>

            <textarea id="result" rows="12" placeholder="Extracted text will appear here..."></textarea>
        </form>
    </div>

    <!-- Use older, more stable version -->
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@2.1.5/dist/tesseract.min.js"></script>

    <script>
        // Global worker variable
        let currentWorker = null;

        // Preview image when selected
        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);

                document.getElementById('progress').innerHTML = 'Image loaded. Ready to scan!';
            } else {
                preview.style.display = 'none';
            }
        });

        async function processOCR() {
            const imageInput = document.getElementById('imageInput');
            const file = imageInput.files[0];
            const progressDiv = document.getElementById('progress');
            const resultTextarea = document.getElementById('result');
            const scanButton = document.getElementById('scanButton');

            // Validation
            if (!file) {
                alert('❌ Please select an image first!');
                return;
            }

            // Check file type
            if (!file.type.startsWith('image/')) {
                alert('❌ Please select a valid image file!');
                return;
            }

            // Check file size (max 10MB)
            if (file.size > 10 * 1024 * 1024) {
                alert('❌ File too large! Please select an image smaller than 10MB.');
                return;
            }

            try {
                // UI updates
                scanButton.disabled = true;
                scanButton.innerHTML = '⏳ Processing...';
                progressDiv.innerHTML = '<span class="loading">🚀 Starting OCR engine...</span>';
                resultTextarea.value = '';

                // Simple worker creation without complex options
                progressDiv.innerHTML = '<span class="loading">📚 Loading language data...</span>';

                // Use the most basic approach
                currentWorker = Tesseract.createWorker({
                    logger: function(m) {
                        console.log('OCR Progress:', m);

                        if (m.status) {
                            let emoji = '⏳';
                            if (m.status === 'recognizing text') emoji = '👁️';
                            if (m.status === 'loading language') emoji = '📚';
                            if (m.status === 'initializing tesseract') emoji = '🔧';

                            const progress = m.progress ? Math.round(m.progress * 100) + '%' : '';
                            progressDiv.innerHTML =
                                `<span class="loading">${emoji} ${m.status} ${progress}</span>`;
                        }
                    }
                });

                // Initialize step by step
                await currentWorker.load();
                await currentWorker.loadLanguage('eng');
                await currentWorker.initialize('eng');

                // Process the image
                progressDiv.innerHTML = '<span class="loading">👁️ Analyzing image...</span>';
                const {
                    data: {
                        text
                    }
                } = await currentWorker.recognize(file);

                // Show results
                if (text.trim()) {
                    resultTextarea.value = text;
                    progressDiv.innerHTML = '<span class="success">✅ OCR completed successfully!</span>';

                    // Send to backend
                    await sendToBackend(text, file.name);
                } else {
                    resultTextarea.value = 'No text detected in the image.';
                    progressDiv.innerHTML = '<span class="error">⚠️ No text found in the image.</span>';
                }

            } catch (error) {
                console.error('OCR Error:', error);
                progressDiv.innerHTML = `<span class="error">❌ Error: ${error.message}</span>`;
                resultTextarea.value = `Error occurred: ${error.message}`;

            } finally {
                // Cleanup
                if (currentWorker) {
                    try {
                        await currentWorker.terminate();
                    } catch (e) {
                        console.log('Worker cleanup error:', e);
                    }
                    currentWorker = null;
                }

                // Reset UI
                scanButton.disabled = false;
                scanButton.innerHTML = '🔍 Scan Text';
            }
        }

        async function sendToBackend(text, filename) {
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) {
                    console.warn('CSRF token not found');
                    return;
                }

                const response = await fetch('/ocr', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken.content
                    },
                    body: JSON.stringify({
                        text: text,
                        filename: filename,
                        timestamp: new Date().toISOString()
                    })
                });

                if (response.ok) {
                    const result = await response.json();
                    console.log('✅ Sent to backend:', result);
                } else {
                    console.error('❌ Backend error:', await response.text());
                }

            } catch (error) {
                console.error('❌ Network error:', error);
            }
        }

        // Cleanup on page unload
        window.addEventListener('beforeunload', async () => {
            if (currentWorker) {
                try {
                    await currentWorker.terminate();
                } catch (e) {
                    console.log('Cleanup error:', e);
                }
            }
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🎯 OCR application loaded');
        });
    </script>
</body>

</html>
