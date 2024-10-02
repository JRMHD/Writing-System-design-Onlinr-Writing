@extends('layouts.employer')

@section('content')
    <div
        style="max-width: 800px; margin: 0 auto; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <h1
            style="font-family: 'Poppins', sans-serif; font-size: 28px; font-weight: 600; color: #14a800; margin-bottom: 20px;">
            Create Assignment
        </h1>

        @if ($errors->any())
            <div
                style="background-color: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 10px; margin-bottom: 20px;">
                <ul style="list-style-type: disc; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="assignmentForm" action="{{ route('employer.assignments.store') }}" method="POST"
            enctype="multipart/form-data" style="font-family: 'Poppins', Arial, sans-serif;">
            @csrf

            <!-- Step 1: Basic Details -->
            <fieldset id="step1" style="border: none; padding: 0; margin: 0;">
                <legend style="font-size: 25px; font-weight: 600; color: #333; margin-bottom: 15px;">Step 1: Basic Details
                </legend>

                <div style="margin-bottom: 15px;">
                    <label for="title"
                        style="display: block; font-size: 15px; font-weight: 500; color: #333; margin-bottom: 5px;">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="word_count"
                        style="display: block; font-size: 15px; font-weight: 500; color: #333; margin-bottom: 5px;">Word
                        Count</label>
                    <input type="number" name="word_count" id="word_count" value="{{ old('word_count') }}" required
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="deadline"
                        style="display: block; font-size: 15px; font-weight: 500; color: #333; margin-bottom: 5px;">Deadline</label>
                    <input type="date" name="deadline" id="deadline" value="{{ old('deadline') }}" required
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="budget"
                        style="display: block; font-size: 15px; font-weight: 500; color: #333; margin-bottom: 5px;">Budget</label>
                    <input type="number" name="budget" id="budget" value="{{ old('budget') }}" required
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="description"
                        style="display: block; font-size: 15px; font-weight: 500; color: #333; margin-bottom: 5px;">Description</label>
                    <textarea name="description" id="description" required
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px; height: 100px;">{{ old('description') }}</textarea>
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="file"
                        style="display: block; font-size: 15px; font-weight: 500; color: #333; margin-bottom: 5px;">Upload
                        File (PDF, DOC, DOCX, max 2MB)</label>
                    <div id="drop-area"
                        style="border: 2px dashed #ccc; border-radius: 4px; padding: 20px; text-align: center; cursor: pointer;">
                        <p>Drag and drop files here or click to select</p>
                        <input type="file" name="file" id="file" accept=".pdf,.doc,.docx" style="display: none;">
                    </div>
                    <div id="file-name" style="margin-top: 10px; font-size: 14px;"></div>
                </div>

                <button type="button" onclick="showStep2()"
                    style="width: 100%; background-color: #14a800; color: #fff; padding: 12px; border: none; border-radius: 4px; font-size: 16px; font-weight: 600; cursor: pointer; transition: background-color 0.3s;">
                    Next
                </button>
            </fieldset>

            <!-- Step 2: Additional Details -->
            <fieldset id="step2" style="display:none; border: none; padding: 0; margin: 0;">
                <legend style="font-size: 25px; font-weight: 600; color: #333; margin-bottom: 15px;">Step 2: Additional
                    Details</legend>

                <div style="margin-bottom: 15px;">
                    <label for="language"
                        style="display: block; font-size: 15px; font-weight: 500; color: #333; margin-bottom: 5px;">Language</label>
                    <select name="language" id="language" required
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;">
                        <option value="">Select Language</option>
                        <option value="English US">English (US)</option>
                        <option value="English UK">English (UK)</option>
                        <option value="Spanish">Spanish</option>
                        <option value="French">French</option>
                        <option value="German">German</option>
                        <option value="Chinese">Chinese</option>
                        <option value="Japanese">Japanese</option>
                        <option value="Russian">Russian</option>
                        <option value="Portuguese">Portuguese</option>
                        <option value="Italian">Italian</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="academic_level"
                        style="display: block; font-size: 15px; font-weight: 500; color: #333; margin-bottom: 5px;">Academic
                        Level</label>
                    <select name="academic_level" id="academic_level" required
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;">
                        <option value="">Select Academic Level</option>
                        <option value="High School">High School</option>
                        <option value="Undergraduate">Undergraduate</option>
                        <option value="Postgraduate">Postgraduate</option>
                        <option value="Doctorate">Doctorate</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="topic"
                        style="display: block; font-size: 15px; font-weight: 500; color: #333; margin-bottom: 5px;">Topic</label>
                    <select name="topic" id="topic" required
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;">
                        <option value="">Select Topic</option>
                        <option value="Business">Business</option>
                        <option value="Technology">Technology</option>
                        <option value="Health">Health</option>
                        <option value="Science">Science</option>
                        <option value="Law">Law</option>
                        <option value="Education">Education</option>
                        <option value="Arts">Arts</option>
                        <option value="Social Sciences">Social Sciences</option>
                        <option value="Engineering">Engineering</option>
                        <option value="Finance">Finance</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div style="display: flex; justify-content: space-between;">
                    <button type="button" onclick="showStep1()"
                        style="width: 48%; background-color: #f0f0f0; color: #333; padding: 12px; border: none; border-radius: 4px; font-size: 16px; font-weight: 600; cursor: pointer; transition: background-color 0.3s;">
                        Back
                    </button>
                    <button type="submit"
                        style="width: 48%; background-color: #14a800; color: #fff; padding: 12px; border: none; border-radius: 4px; font-size: 16px; font-weight: 600; cursor: pointer; transition: background-color 0.3s;">
                        Submit
                    </button>
                </div>
            </fieldset>
        </form>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 20px;
        }

        button:hover {
            background-color: #0e8000 !important;
        }

        #drop-area {
            transition: background-color 0.3s, border-color 0.3s;
        }

        #drop-area.highlight {
            background-color: #f0f0f0;
            border-color: #14a800;
        }
    </style>

    <script>
        function showStep2() {
            document.getElementById('step1').style.display = 'none';
            document.getElementById('loadingOverlay').style.display = 'flex';
            setTimeout(() => {
                document.getElementById('loadingOverlay').style.display = 'none';
                document.getElementById('step2').style.display = 'block';
            }, 1000);
        }

        function showStep1() {
            document.getElementById('step2').style.display = 'none';
            document.getElementById('loadingOverlay').style.display = 'flex';
            setTimeout(() => {
                document.getElementById('loadingOverlay').style.display = 'none';
                document.getElementById('step1').style.display = 'block';
            }, 1000);
        }

        // File upload functionality
        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('file');
        const fileNameDisplay = document.getElementById('file-name');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            dropArea.classList.add('highlight');
        }

        function unhighlight() {
            dropArea.classList.remove('highlight');
        }

        dropArea.addEventListener('drop', handleDrop, false);

        dropArea.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }

        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];
                if (validateFile(file)) {
                    fileInput.files = files;
                    displayFileName(file.name);
                } else {
                    alert('Please upload a PDF, DOC, or DOCX file under 2MB.');
                }
            }
        }

        function validateFile(file) {
            const validTypes = ['application/pdf', 'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            const maxSize = 2 * 1024 * 1024; // 2MB
            return validTypes.includes(file.type) && file.size <= maxSize;
        }

        function displayFileName(name) {
            fileNameDisplay.textContent = `File selected: ${name}`;
        }
    </script>

    <div id="loadingOverlay"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 1000;">
        <div
            style="border: 5px solid #f3f3f3; border-top: 5px solid #14a800; border-radius: 50%; width: 50px; height: 50px; animation: spin 1s linear infinite;">
        </div>
    </div>

    <style>
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection
