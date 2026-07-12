<div class="bg-white p-6 rounded-lg shadow-lg relative" x-data="{
    search: '',
    results: { courses: [], departments: [], staff: [], posts: [] },
    isLoading: false,
    noResults: false,
    resetSearch() {
        this.search = '';
        this.results = { courses: [], departments: [], staff: [], posts: [] };
    },
    async searchData() {
        if (this.search.length < 2) {
            this.resetSearch();
            return;
        }
        this.isLoading = true;
        try {
            const url = new URL('{{ route('front.search') }}');
            url.searchParams.set('query', this.search);
            const response = await fetch(url);
            const data = await response.json();
            this.noResults = data.posts.length === 0 && data.staff.length === 0 && data.courses.length === 0 && data.departments.length === 0;
            this.results = data;
        } catch (error) {
            console.error(error);
        } finally {
            this.isLoading = false;
        }
    }
}" @click.away="resetSearch()"
    @keydown.escape="resetSearch()">
    <!-- Search Input -->
    <div class="relative flex items-center border-b border-gray-300 pb-3">

        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-5 h-5 text-gray-500 absolute left-3">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
        </svg>

        <input type="text" placeholder="Search..." class="text-input" x-model="search"
            @input.debounce.500ms="searchData()">
    </div>

    <!-- Scrollable Search Results -->
    <div x-show="!isLoading && !search" class="mt-4 max-h-[300px] overflow-y-auto border-b border-gray-300 pb-3">
        <p class="text-gray-500 text-xs py-6 text-center">Search results will be displayed here</p>
    </div>

    <!-- Loading -->

    <div class="grid min-h-[120px] w-full place-items-center overflow-x-scroll rounded-lg p-6 lg:overflow-visible"
        x-show="isLoading">
        <svg class="w-16 h-16 animate-spin text-mustBlue/50" viewBox="0 0 64 64" fill="none"
            xmlns="http://www.w3.org/2000/svg" width="24" height="24">
            <path
                d="M32 3C35.8083 3 39.5794 3.75011 43.0978 5.20749C46.6163 6.66488 49.8132 8.80101 52.5061 11.4939C55.199 14.1868 57.3351 17.3837 58.7925 20.9022C60.2499 24.4206 61 28.1917 61 32C61 35.8083 60.2499 39.5794 58.7925 43.0978C57.3351 46.6163 55.199 49.8132 52.5061 52.5061C49.8132 55.199 46.6163 57.3351 43.0978 58.7925C39.5794 60.2499 35.8083 61 32 61C28.1917 61 24.4206 60.2499 20.9022 58.7925C17.3837 57.3351 14.1868 55.199 11.4939 52.5061C8.801 49.8132 6.66487 46.6163 5.20749 43.0978C3.7501 39.5794 3 35.8083 3 32C3 28.1917 3.75011 24.4206 5.2075 20.9022C6.66489 17.3837 8.80101 14.1868 11.4939 11.4939C14.1868 8.80099 17.3838 6.66487 20.9022 5.20749C24.4206 3.7501 28.1917 3 32 3L32 3Z"
                stroke="currentColor" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"></path>
            <path
                d="M32 3C36.5778 3 41.0906 4.08374 45.1692 6.16256C49.2477 8.24138 52.7762 11.2562 55.466 14.9605C58.1558 18.6647 59.9304 22.9531 60.6448 27.4748C61.3591 31.9965 60.9928 36.6232 59.5759 40.9762"
                stroke="currentColor" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"
                class="text-mustBlue">
            </path>
        </svg>
    </div>


    <!-- No Results -->
    <div x-show="!isLoading && noResults"
        class="mt-4 max-h-[300px] overflow-y-auto border-b border-gray-300 pb-3">
        <p class="text-gray-500 text-xs py-6 text-center">No results found</p>
    </div>

    <template x-if="results.courses?.length">
        <div class="mt-4 max-h-[250px] overflow-y-auto border-b border-gray-300 pb-3">
            <p class="text-gray-500 text-xs uppercase font-semibold tracking-wide border-l-4 border-mustBlue pl-2">
                <svg class="w-4 h-4 inline-block text-mustBlue mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 21v-2a4 4 0 00-8 0v2m8-4a4 4 0 00-8 0" />
                </svg>
                Courses
            </p>

            <template x-for="course in results.courses" :key="course.id">
                <a :href="`/courses/${course.slug}`"
                    class="block p-4 rounded-lg shadow-sm transition duration-200 hover:bg-gray-100">
                    <h3 class=" font-semibold text-gray-900 hover:text-mustGreen" x-text="course.name"></h3>
                </a>
            </template>
        </div>
    </template>

    <template x-if="results.staff?.length">
        <div class="mt-4 max-h-[250px] overflow-y-auto border-b border-gray-300 pb-3">
            <p class="text-gray-500 text-xs uppercase font-semibold tracking-wide border-l-4 border-mustBlue pl-2">
                <svg class="w-4 h-4 inline-block text-mustBlue mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Staff
            </p>

            <template x-for="staff in results.staff" :key="staff.id">
                <div class="p-4 rounded-lg shadow-sm transition duration-200 hover:bg-gray-100">
                    <p class="font-semibold text-gray-900 hover:text-mustGreen" x-text="staff.name"></p>
                    <p class="text-gray-500 text-sm" x-text="staff.position"></p>
                </div>
            </template>
        </div>
    </template>

    <template x-if="results.posts?.length">
        <div class="mt-4 max-h-[250px] overflow-y-auto border-b border-gray-300 pb-3">
            <p class="text-gray-500 text-xs uppercase font-semibold tracking-wide border-l-4 border-mustBlue pl-2">
                <svg class="w-4 h-4 inline-block text-mustBlue mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 5H5m14 6H5m14 6H5" />
                </svg>
                News & Events
            </p>

            <template x-for="post in results.posts" :key="post.id">
                <a :href="`/news/${post.slug}`"
                    class="block p-4 rounded-lg shadow-sm transition duration-200 hover:bg-gray-100">
                    <h3 class=" font-semibold text-gray-900 hover:text-mustGreen" x-text="post.title"></h3>
                </a>
            </template>
        </div>
    </template>

    <template x-if="results.departments?.length">
        <div class="mt-4 max-h-[250px] overflow-y-auto border-b border-gray-300 pb-3">
            <p class="text-gray-500 text-xs uppercase font-semibold tracking-wide border-l-4 border-green-500 pl-2">
                <svg class="w-4 h-4 inline-block text-green-500 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h11m0 0l4-4m-4 4l4 4" />
                </svg>
                Departments
            </p>

            <template x-for="department in results.departments" :key="department.id">
                <a :href="`/department/${department.slug}`"
                    class="block p-4 rounded-lg shadow-sm transition duration-200 hover:bg-gray-100">
                    <h3 class=" font-semibold text-gray-900 hover:text-mustGreen" x-text="department.name"></h3>
                </a>
            </template>
        </div>
    </template>


    <!-- Footer -->
    <div class="mt-3 text-center text-gray-500 text-sm">
        Press <kbd class="px-2 py-1 bg-gray-200 rounded">Esc</kbd> to close
    </div>
</div>
