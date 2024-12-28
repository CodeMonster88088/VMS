<x-layout>
    <x-slot:heading>
        Checking In Visitors
    </x-slot:heading>

    <div class="container mx-auto mt-10 px-4">
        <!-- Title -->
        <h1 class="text-3xl font-bold text-center text-indigo-600 mb-6">Reading Smartcard And Checking In</h1>

        <!-- Smartcard Reading Form -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <form id="smartcard-form" class="space-y-6">
                <!-- Server URL -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2" style="display: none">
                        <label for="txtServerURL" class="block text-sm font-medium text-gray-700">RESTful Server URL</label>
                        <input type="text" id="txtServerURL" name="txtServerURL" value="http://localhost:5050/api/operation/ReadCard"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm font-semibold" />
                    </div>
                </div>

                <!-- Read Smartcard Button -->
                <div class="flex justify-end space-x-4">
                    <button type="button" id="btnReadSmartcard" class="py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Read Smartcard
                    </button>

                    <!-- Checkin Button -->
                    <button type="button" id="btnCheckin" class="py-2 px-4 bg-green-600 text-white font-semibold rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        Checkin
                    </button>
                </div>
            </form>
        </div>

        <!-- Smartcard Data Table -->
        <div id="cardDataSection" class="bg-white shadow-lg rounded-lg p-6 mt-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Smartcard Data</h2>
            <table id="tbDetails" class="min-w-full table-auto border-collapse border border-gray-300">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left font-semibold text-gray-700">Field</th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-700">Value</th>
                </tr>
                </thead>
                <tbody>
                <tr><td class="px-4 py-2 text-gray-700">Photo</td><td><img id="Photo" src="data:image/png;base64, " ></td></tr>
                <tr><td class="px-4 py-2 text-gray-700">CPR Number</td><td><input type="text" id="IdNumber" class="w-full p-2 border border-gray-300 rounded-md" /></td></tr>
                <tr><td class="px-4 py-2 text-gray-700">Full Name</td><td><input type="text" id="arabicFullName" class="w-full p-2 border border-gray-300 rounded-md" /></td></tr>
                <tr><td class="px-4 py-2 text-gray-700">Address</td><td><input type="text" id="addressArabic" class="w-full p-2 border border-gray-300 rounded-md" /></td></tr>
                <tr style="display: none"><td class="px-4 py-2 text-gray-700">AddressEnglish</td><td><input type="text" id="addressEnglish" class="w-full p-2 border border-gray-300 rounded-md" /></td></tr>

                <tr><td class="px-4 py-2 text-gray-700">Birth Date</td><td><input type="text" id="birthDate" class="w-full p-2 border border-gray-300 rounded-md" /></td></tr>
                <tr><td class="px-4 py-2 text-gray-700">Card Country</td><td><input type="text" id="cardCountry" class="w-full p-2 border border-gray-300 rounded-md" /></td></tr>
                <tr><td class="px-4 py-2 text-gray-700">Card Expiry Date</td><td><input type="text" id="cardexpiryDate" class="w-full p-2 border border-gray-300 rounded-md" /></td></tr>
                <tr style="display: none"><td class="px-4 py-2 text-gray-700">CardSerialNumber</td><td><input type="text" id="cardSerialNumber" class="w-full p-2 border border-gray-300 rounded-md" /></td></tr>
                <tr><td class="px-4 py-2 text-gray-700">Gender</td><td><input type="text" id="gender" class="w-full p-2 border border-gray-300 rounded-md" /></td></tr>
                <tr><td class="px-4 py-2 text-gray-700">Nationality Code</td><td><input type="text" id="nationalityCode" class="w-full p-2 border border-gray-300 rounded-md" /></td></tr>
                <tr><td class="px-4 py-2 text-gray-700">Passport Number</td><td><input type="text" id="passportNumber" class="w-full p-2 border border-gray-300 rounded-md" /></td></tr>
                </tbody>
            </table>
        </div>

        <!-- Message Section -->
        <div id="message" class="mt-4"></div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript">
        $(function () {
            // Read Smartcard Button
            $('#btnReadSmartcard').click(function () {
                $.support.cors = true;
                $("#btnReadSmartcard").text('Please wait...');
                $('#btnReadSmartcard').prop("disabled", true);

                $.ajax({
                    type: "POST",
                    url: $("#txtServerURL").val(),
                    data: JSON.stringify({
                        "ReadCardInfo": true,
                        "ReadPersonalInfo": true,
                        "ReadAddressDetails": true,
                        "ReadBiometrics": true,
                        "ReadEmploymentInfo": true,
                        "ReadImmigrationDetails": true,
                        "ReadTrafficDetails": true,
                        "SilentReading": false,
                        "ReaderIndex": -1,
                        "ReaderName": "",
                        "OutputFormat": "json",
                        "ValidateCard": true
                    }),
                    success: function (data) {
                        $("#btnReadSmartcard").text('Read Smartcard');
                        $('#btnReadSmartcard').prop("disabled", false);

                        const fields = [
                            'Photo', 'AddressArabic', 'AddressEnglish', 'ArabicFullName', 'BirthDate',
                            'CardCountry', 'CardSerialNumber', 'Gender', 'NationalityCode', 'PassportNumber', 'CardexpiryDate'
                        ];

                        fields.forEach(field => {
                            const fieldId = field.charAt(0).toLowerCase() + field.slice(1);
                            const fieldValue = data[field] || '';
                            $('#' + fieldId).val(fieldValue);
                        });

                        if (data['Photo']) {
                            $('#Photo').attr('src', 'data:image/png;base64,' + data['Photo']);
                        }
                        $('#IdNumber').val(data["IdNumber"]);
                    },
                    error: function (xhr, tst, err) {
                        $("#btnReadSmartcard").text('Read Smartcard');
                        $('#btnReadSmartcard').prop("disabled", false);
                        alert('Error: ' + xhr.responseText);
                    }
                });
            });

            // Checkin Button Click
            $('#btnCheckin').click(function () {
                const requiredFields = [
                    { id: '#IdNumber', name: 'CPR Number' },
                    { id: '#arabicFullName', name: 'Full Name' }
                ];

                let missingField = null;

                // Check for empty fields
                requiredFields.forEach(field => {
                    if (!$(field.id).val() && !missingField) {
                        missingField = field.name; // Capture the first missing field
                    }
                });

                // If a missing field is found, show an alert and stop execution
                if (missingField) {
                    alert(`Please fill out "${missingField}".`);
                    return;
                }
                // Get the logged-in user's ID from a meta tag or a hidden input field
                const userId = $('meta[name="auth-user-id"]').attr('content'); // Ensure this meta tag is present in your Blade layout

                const formData = {
                    user_id: userId, // Add the authenticated user's ID
                    id_number: $('#IdNumber').val(),
                    arabic_full_name: $('#arabicFullName').val(),
                    birth_date: $('#birthDate').val(),
                    nationality_code: $('#nationalityCode').val(),
                    passport_number: $('#passportNumber').val(),
                    photo: $('#Photo').attr('src'),
                    gender: $('#gender').val(),
                    card_country: $('#cardCountry').val(),
                    card_expiry_date: $('#cardexpiryDate').val(),
                    card_serial_number: $('#cardSerialNumber').val(),
                    address_arabic: $('#addressArabic').val(),
                    address_english: $('#addressEnglish').val(),
                };

                $.ajax({
                    type: "POST",
                    url: "{{ route('checkin.save') }}", // Update with route
                    data: JSON.stringify(formData),
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        $('#message').html('<div class="text-green-600">Check-in successful!</div>');
                    },
                    error: function (xhr) {
                        $('#message').html('<div class="text-red-600">Check-in failed: ' + xhr.responseText + '</div>');
                    }
                });
            });
        });
    </script>

</x-layout>
