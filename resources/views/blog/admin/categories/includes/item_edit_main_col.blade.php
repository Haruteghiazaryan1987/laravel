@php
/** @var \App\Models\BlogCategory $item */
/** @var \Illuminate\Support\Collection $categoryList */
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title"></div>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#maindata" role="tab">Основние данные</a>
                    </li>
                </ul>
                <br>
                <div class="tab-content">
                    <div class="tab-pane active" id="maindata" role="tabpanel">
                        <div class="form-group">
                            <label for="title">Загаловок</label>
                            <input type="text" name="title" id="title" value="{{ $item->title }}" class="form-control"
                                minlength="3" required>
                        </div>

                        <div class="form-group">
                            <label for="slug">Индентификатор</label>
                            <input type="text" name="slug" id="slug" value="{{ $item->slug }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="parent_id">Родитель</label>
                            <select name="parent_id" id="parent_id" class="form-control" placeholder="Бибрите категорию"
                                required>
                                @foreach ($categoryList as $categoryOption)
                                    <option value="{{ $categoryOption->id }}" @if ($categoryOption->id == $item->parent_id) selected
                                @endif>
                                {{-- {{ $categoryOption->id }}.{{ $categoryOption->title }} --}}
                                {{ $categoryOption->id_title }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="description">Описние</label>
                            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description',$item->description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
