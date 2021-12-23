<div>

    <x-table>
        <div class="px-6 py-4 flex items-center">
            @livewire('create-post')
           <x-jet-input type="text" wire:model='search' class="ml-2 flex-1 " placeholder="Escribe el post a buscar..." /> 
        </div>
        <div wire:loading class="flex justify-center">
            Ordenando registros...
        </div>
        
        @if ($posts->count())
            <table class="table-auto w-full">

                <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                    <tr>
                        <th wire:click="order('id')" class="cursor-pointer p-2 whitespace-nowrap">
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
                    @foreach ($posts as $post)
                        <tr class="hover:bg-gray-50 focus-within:bg-gray-100">
                            <td class="p-2 ">
                                {{$post->id}}
                            </td>
                            <td class="p-2 ">
                                <div class="text-left"> {{$post->title}}</div>
                            </td>
                            <td class="p-2 ">
                                <div class="text-left"> {{$post->content}}</div>
                            </td>
                            <td class="p-2 ">
                                @livewire('edit-post', ['post' => $post], key($post->id))
                            </td>
                        </tr> 
                    @endforeach
        
                </tbody>
            </table>
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

</div>