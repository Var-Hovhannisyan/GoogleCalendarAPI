<div class="relative z-10 hidden" id="{{$id}}" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <form action="{{route('events.create')}}" method="get"
                  class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-base font-semibold text-gray-900"
                                id="modal-title">{{ $title ?? 'Deactivate account' }}</h3>
                            <div class="mt-2">
                                <label for="">Event title</label>
                                <p class="text-sm text-gray-500">
                                    <input name="title" id="event-title-input" type="text"
                                           class="border-2 border-secondary p-3 border-blue-700 outline-blue-500">
                                </p>
                            </div>
                            <div class="mt-2">
                                <label for="">Event description</label>
                                <p class="text-sm text-gray-500">
                                    <textarea name="description" id="event-description-input"
                                              class="border-2 border-secondary p-3 border-blue-700 outline-blue-500"></textarea>
                                </p>
                            </div>
                            <div class="mt-2">
                                <x-colors_select/>
                            </div>
                            <div class="mt-2">
                                <label for="">Start time</label>
                                <p class="text-sm text-gray-500">
                                    <input type="datetime-local" name="start_date_time" id="start-datetime-input"
                                           class="border-2 border-secondary p-3 border-blue-700 outline-blue-500">
                                </p>
                            </div>
                            <div class="mt-2">
                                <label for="">End time</label>
                                <p class="text-sm text-gray-500">
                                    <input type="datetime-local" name="end_date_time" id="end-datetime-input"
                                           class="border-2 border-secondary p-3 border-blue-700 outline-blue-500">
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="submit"
                            class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto"
                            id="modal-deactivate-button">
                        {{ $deactivateButtonText ?? 'Save' }}
                    </button>
                    <button type="button"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto"
                            id="modal-cancel-button">
                        {{ $cancelButtonText ?? 'Cancel' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
