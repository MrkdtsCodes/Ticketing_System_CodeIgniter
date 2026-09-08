<script>
    const BASE_URL = "<?= base_url() ?>";
</script>

<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-lg border border-gray-200">

    <!-- Header -->
    <div class="border-b border-gray-200 px-8 py-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Student Information
        </h2>

        <p class="text-gray-500 mt-1">
            Fill out the student's information below.
        </p>
    </div>

    <!-- Form -->
    <form class="p-8 space-y-6 student-row" action="<?= base_url('')?>" id="form_data">

        <div class="student-row" >
                <!-- Name -->
            <div id="adxyz">
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Student Name
                    </label>
                    <input
                        type="text"
                        placeholder="Enter student name"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3
                            focus:ring-2 focus:ring-blue-500
                            focus:border-blue-500
                            outline-none transition"
                        name="data[adxyz][name]"
                        >
                </div>
                <!-- Email -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Email Address
                    </label>
                    <input
                        type="email"
                        placeholder="example@email.com"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3
                            focus:ring-2 focus:ring-blue-500
                            focus:border-blue-500
                            outline-none transition"
                        name="data[adxyz][email]"
                    >
                        
                </div>
                <!-- Grid -->
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Course -->
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700">
                            Course
                        </label>
                        <select
                            class="w-full rounded-lg border border-gray-300 px-4 py-3
                                focus:ring-2 focus:ring-blue-500
                                focus:border-blue-500
                                outline-none transition"
                            name="data[adxyz][course]">
                            <option selected value="">Select Course</option>
                            <option value="BSIT">BSIT</option>
                            <option value="BSCS">BSCS</option>
                            <option value="BSIS">BSIS</option>
                            <option value="BSA">BSA</option>
                        </select>
                    </div>
                    <!-- Age -->
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700">
                            Age
                        </label>
                        <input
                            type="number"
                            placeholder="21"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3
                                focus:ring-2 focus:ring-blue-500
                                focus:border-blue-500
                                outline-none transition"
                            name="data[adxyz][age]"
                            >
                    </div>
                </div>
                <!-- Address -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Address
                    </label>
                    <textarea
                        rows="4"
                        placeholder="Enter complete address..."
                        class="w-full rounded-lg border border-gray-300 px-4 py-3
                            focus:ring-2 focus:ring-blue-500
                            focus:border-blue-500
                            outline-none transition resize-none"
                        name="data[adxyz][address]"></textarea>
                </div>
            </div>
        </div>

        <div class="student-row" >
                <!-- Name -->
            <div id="abcd">
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Student Name
                    </label>
                    <input
                        type="text"
                        placeholder="Enter student name"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3
                            focus:ring-2 focus:ring-blue-500
                            focus:border-blue-500
                            outline-none transition"
                        name="data[abcd][name]"
                        >
                </div>
                <!-- Email -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Email Address
                    </label>
                    <input
                        type="email"
                        placeholder="example@email.com"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3
                            focus:ring-2 focus:ring-blue-500
                            focus:border-blue-500
                            outline-none transition"
                        name="data[abcd][email]"
                    >
                        
                </div>
                <!-- Grid -->
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Course -->
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700">
                            Course
                        </label>
                        <select
                            class="w-full rounded-lg border border-gray-300 px-4 py-3
                                focus:ring-2 focus:ring-blue-500
                                focus:border-blue-500
                                outline-none transition"
                            name="data[abcd][course]">
                            <option selected value="">Select Course</option>
                            <option value="BSIT">BSIT</option>
                            <option value="BSCS">BSCS</option>
                            <option value="BSIS">BSIS</option>
                            <option value="BSA">BSA</option>
                        </select>
                    </div>
                    <!-- Age -->
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700">
                            Age
                        </label>
                        <input
                            type="number"
                            placeholder="21"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3
                                focus:ring-2 focus:ring-blue-500
                                focus:border-blue-500
                                outline-none transition"
                            name="data[abcd][age]"
                            >
                    </div>
                </div>
                <!-- Address -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Address
                    </label>
                    <textarea
                        rows="4"
                        placeholder="Enter complete address..."
                        class="w-full rounded-lg border border-gray-300 px-4 py-3
                            focus:ring-2 focus:ring-blue-500
                            focus:border-blue-500
                            outline-none transition resize-none"
                        name="data[abcd][address]"></textarea>
                </div>
            </div>
        </div> 

        <div class="flex justify-end gap-3 pt-4 border-t">
                <button
                    type="reset"
                    class="px-6 py-3 rounded-lg border border-gray-300
                        hover:bg-gray-100
                        transition">
                    Cancel
                </button>
                <button
                    type="submit"
                    class="px-6 py-3 rounded-lg bg-blue-600 text-white
                        hover:bg-blue-700
                        transition
                        shadow">
                    Save Student
                </button>
        </div>
    </form>

</div>

<div class="displayresulthere">

</div>
<script src="./assets/JavaScript/batch_updates_insert.js"></script>