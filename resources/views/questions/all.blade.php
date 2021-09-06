<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Questions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl p-8 sm:rounded-lg">
                @foreach($questionList->getItems() as $question)
                    <h3 class="@if (!$loop->first) mt-6 @endif text-xl">{{ $question->getText() }}</h3>
                    @foreach($question->getChoices() as $choice)
                        <p class="pl-3 mt-2">{{ $choice->getText() }}</p>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl p-8 sm:rounded-lg">
                <div class="text-lg text-bold">Create Question</div>
                <form method="POST" action="{{ route('questions.create') }}">
                    <x-jet-input placeholder="Question" type="text" class="mt-1" name="question" />
                    <x-jet-input placeholder="Created at" type="text" class="mt-1" name="createdAt" value="{{ $createdAtDefault }}" />
                    <div class="mt-2">
                        @for($i=1; $i<=3; $i++)
                            <x-jet-input placeholder="Choice #{{$i}}" type="text" class="mt-1" name="choices[]" />
                        @endfor
                    </div>
                    @csrf
                    <x-jet-button class="mt-4">Submit</x-jet-button>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
