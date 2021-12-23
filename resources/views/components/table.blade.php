<section class="antialiased bg-gray-100 text-gray-600  px-4 py-12">
  <div class="flex flex-col justify-center h-full">
      <!-- Table -->
      <div class="w-full  mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
          <header class="px-5 py-4 border-b border-gray-100">
              <h2 class="font-semibold text-gray-800">Customers</h2>
          </header>
          <div class="p-3">
              <div class="overflow-x-auto">
                {{$slot}}
              </div>
          </div>
      </div>
  </div>
</section>
