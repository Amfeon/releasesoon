
<label class="control-label">Название фильма</label>
<input type="text" class="form-control"  name="title"  value="{{$massData['title']}}" required>

<label class="control-label">Оригинальное</label>
<input type="text" class="form-control"  name="original" value="{{$massData['original']}}" required >

<label class="control-label">Дата выхода</label>

<input type="date" class="form-control"  name="release" value="{{$massData['data']}}" required>

<label class="control-label">Блю-рей релиз</label>
<input type="date" class="form-control"  name="Blu_ray"  value="{{@date('Y-m-d')}}" required>

<label class="control-label">Картинка</label>
<input type="text" class="form-control"  name="image" required value="{{$massData['image']}}">


