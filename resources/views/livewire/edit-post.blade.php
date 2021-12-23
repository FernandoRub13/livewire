<div>
    <button wire:loading.attr="disabled" class="btn btn-blue" wire:click.prefetch="$set('open', true)">
        <i class="fas fa-edit"></i>
    </button>
    <x-jet-dialog-modal wire:model="open">

        <x-slot name="title">
            Editar el post {{{$post->title}}}
        </x-slot>
        <x-slot name="content">
            {{-- MAke an alert in color teal --}}
            <div wire:loading wire:target="image"
                class="w-full mb-4 bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md"
                role="alert">
                <div class="flex">
                    <div class="py-1">
                        {{-- Make a sand clock --}}
                        <svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <path
                                d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm-5.6-4.29a9.95 9.95 0 0 1 11.2 0 8 8 0 1 0-11.2 0zm6.12-7.64l3.02-3.02 1.41 1.41-3.02 3.02a2 2 0 1 1-1.41-1.41z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold">¡Cargando imagén!</p>
                        <p class="text-sm">
                            Espere un momento por favor.
                        </p>
                    </div>
                </div>
            </div>

            @if ($image)
            <img src="{{ $image->temporaryUrl() }}" class="mb-4" />
            @else
            <img src="{{ Storage::url($post->image) }}" class="mb-4" />
            @endif
            <div class="mb-4">
                <x-jet-label for="title" value="Titulo" />
                <x-jet-input id="title" type="text" class="block mt-1 w-full" wire:model.defer="post.title" />
                <x-jet-input-error for="title"></x-jet-input-error>
            </div>
            <div class="mb-4">
                <x-jet-label for="content" value="Contenido" />
                <textarea id="content" class="form-control w-full" wire:model.defer="post.content" rows="6"></textarea>
                <x-jet-input-error for="content"></x-jet-input-error>
            </div>
            <div>

                <input type="file" wire:model="image" class="form-control-file" id="identifier" />
                <x-jet-input-error for="image"></x-jet-input-error>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click.prefetch="$toggle('open')" wire:loading.attr="disabled">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button class="ml-2" wire:click="editPost" wire:loading.attr="disabled" wire:target="image,editPost">
                Actualizar
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>