<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-error :errors=$errors />
                    <form method="post" action="{{route('owner.products.store')}}">
                        @csrf
                        <div class="-m-2">
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="name" class="leading-7 text-sm text-gray-600">商品名 ※必須</label>
                                    <input type="text" value="{{old('name')}}" id="name" required name="name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="information" class="leading-7 text-sm text-gray-600">商品情報 ※必須</label>
                                    <textarea rows="10" id="information" required name="information" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{old('information')}}</textarea>
                                </div>
                            </div>
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="price" class="leading-7 text-sm text-gray-600">価格 ※必須</label>
                                    <input type="number" value="{{old('price')}}" id="price" required name="price" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="sort_order" class="leading-7 text-sm text-gray-600">表示順 </label>
                                    <input type="number" value="{{old('sort_order')}}" id="sort_order" name="sort_order" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="quantity" class="leading-7 text-sm text-gray-600">初期在庫 ※必須</label>
                                    <input required type="number" value="{{old('quantity')}}" id="quantity" name="quantity" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="shop_id" class="leading-7 text-sm text-gray-600">販売する店舗 </label>
                                    <select class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" name="shop_id" id="shop_id">
                                    @forEach($shops as $shop)
                                    <option value="{{$shop->id}}">
                                        {{$shop->name}}
                                    </option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="category" class="leading-7 text-sm text-gray-600">カテゴリー </label>
                                    <select id="category" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" name="category">
                                        @foreach ($categories as $category)
                                            <optgroup label="{{$category->name}}">
                                                @foreach ($category->secondary as $secondary)
                                                <option value="{{$secondary->id}}">
                                                    {{$secondary->name}}
                                                </option>
                                                    
                                                @endforeach

                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <x-select-image name="image1" :images="$images"/>
                            <x-select-image name="image2" :images="$images"/>
                            <x-select-image name="image3" :images="$images"/>
                            <x-select-image name="image4" :images="$images"/>
                            <x-select-image name="image5" :images="$images"/>
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative flex justify-around">
                                    <div>
                                        <input type="radio" name="is_selling" class="mr-2" value="1" checked>販売中
                                    </div>
                                    <div>
                                        <input class="mr-2" type="radio" name="is_selling" value="0" >停止中
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 w-full mt-4 flex justify-around">
                                <button type="button" onclick="location.href='{{route('owner.products.index')}}'" class="text-gray-200 bg-gray-400 border-0 py-2 px-8 focus:outline-none hover:bg-gray-600 rounded text-lg">戻る</button>
                                <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録する</button>
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script>
    'use strict'
    const images = document.querySelectorAll('.image');
    images.forEach(image => {
        image.addEventListener('click',function(e) {
            const imageName = e.target.dataset.id.substr(0,6)
            const imageId = e.target.dataset.id.replace(imageName+'_','')
            const imageFile = e.target.dataset.file
            const imagePath = e.target.dataset.path
            const modal = e.target.dataset.modal
            console.log(imageName);

            document.getElementById(imageName+'_thumbnail').src = imagePath+'/'+imageFile
            document.getElementById(imageName+'_hidden').value = imageId
            MicroModal.close(modal);
        })
    })
</script>
</x-app-layout>
