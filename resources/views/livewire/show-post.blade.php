<div wire:init="loadPost" >

    <x-table>
        <div class="px-6 py-4 flex items-center">
            <div class="flex items-center">
                <span>Mostrar</span>
                <select wire:model="quantity" class="ml-2 form-control">
                    <option value="10"> 10 </option>
                    <option value="20"> 20 </option>
                    <option value="50"> 50 </option>
                    <option value="100"> 100 </option>
                </select>
                <span class="ml-2">registros</span>
            </div>
            <x-jet-input type="text" wire:model='search' class="mr-2 flex-1 " placeholder="Escribe el post a buscar..." /> 
            @livewire('create-post')
        </div>
        <div wire:loading class="flex justify-center">
            Ordenando registros...
        </div>
        
        @if (count($posts))
            <table class="table-auto w-full">

                <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                    <tr>
                        <th wire:click="order('id')" class="cursor-pointer p-2 w-8">
                            <div class="font-semibold text-left">ID
                                @if ($sort == 'id')
                                    @if ($direction == 'desc')
                                        <i class="fas fa-sort-down"></i>
                                    @else
                                        <i class="fas fa-sort-up"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort float-right"></i>
                                @endif
                            </div>
                        </th>
                        <th wire:click="order('title')" class="cursor-pointer p-2 whitespace-nowrap">
                            <div class="font-semibold text-left">Title
                                @if ($sort == 'title')
                                    @if ($direction == 'desc')
                                        <i class="fas fa-sort-down float-right"></i>
                                    @else 
                                        <i class="fas fa-sort-up float-right"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort float-right"></i>
                                @endif
                            </div>
                        </th>
                        <th wire:click="order('content')" class="cursor-pointer p-2 whitespace-nowrap">
                            <div class="font-semibold text-left">Content
                                @if ($sort == 'content')
                                    @if ($direction == 'desc')
                                        <i class="fas fa-sort-down float-right"></i>
                                    @else 
                                        <i class="fas fa-sort-up float-right"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort float-right"></i>
                                @endif
                            </div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-center"></div>
                        </th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    @foreach ($posts as $item)
                        <tr class="hover:bg-gray-50 focus-within:bg-gray-100">
                            <td class="p-2 ">
                                {{$item->id}}
                            </td>
                            <td class="p-2 ">
                                <div class="text-left"> {{$item->title}}</div>
                            </td>
                            <td class="p-2 ">
                                <div class="text-left"> {{$item->content}}</div>
                            </td>
                            <td class="p-2 ">
                                {{-- @livewire('edit-item', ['item' => $item], key($item->id)) --}}
                                <button wire:loading.attr="disabled" class="btn btn-blue" wire:click.prefetch="edit({{$item}})">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr> 
                    @endforeach
        
                </tbody>
            </table>
            @if ($posts->hasPages())
                <div class="px-6 py-3">
                    {{ $posts->links() }}
                </div>
                
            @endif
        @else
            <div class="flex justify-center">
                <div class="text-center">
                    <div class="text-gray-500">
                        No hay posts 
                    </div>
                </div>
            </div>
        @endif

            
    </x-table>

    <x-jet-dialog-modal wire:model="open_edit">

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
            <x-jet-secondary-button wire:click.prefetch="$toggle('open_edit')" wire:loading.attr="disabled">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button class="ml-2" wire:click="update" wire:loading.attr="disabled" wire:target="image,editPost">
                Actualizar
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>