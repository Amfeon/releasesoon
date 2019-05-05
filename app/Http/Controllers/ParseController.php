<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Yangqi\Htmldom\Htmldom;
use App\Http\Requests;
use App\film;
use App\FilmChange;
use Symfony\Component\DomCrawler\Crawler;

class ParseController extends Controller
{
    protected $data='';
    protected $actors='';
    protected $director='';
    protected $title='';
    protected $original='';
    //protected $massData=array();
    public 	function dat($mm) {

        if ($mm == "January")
            $mm1 = "01";
        if ($mm == "February")
            $mm1 = "02";
        if ($mm == "March")
            $mm1 = "03";
        if ($mm == "April")
            $mm1 = "04";
        if ($mm == "May")
            $mm1 = "05";
        if ($mm == "June")
            $mm1 = "06";
        if ($mm == "July")
            $mm1 = "07";
        if ($mm == "August")
            $mm1 = "08";
        if ($mm == "September")
            $mm1 = "09";
        if ($mm == "October")
            $mm1 = "10";
        if ($mm == "November")
            $mm1 = "11";
        if ($mm == "December")
            $mm1 = "12";
        return $mm1;
    }
    public function getReleaseImdb($url)
    {
        if ($url != null) {
            $flag = 0;
            preg_match('~tt.[0-9]{1,}~', $url, $a);
            $url = $a[0];
            // $url='http://www.imdb.com/title/tt4765284/';

            $url = 'http://www.imdb.com/title/' . $url . '/';
            $simpleHTML = new Htmldom();
            $all = $simpleHTML->file_get_html($url);
            for ($i = 2; $i < 5; $i++) {
                foreach ($all->find('//*[@id="titleDetails"]/div[' . $i . ']') as $link) {
                    $data = $link->innertext;
                    if (substr_count($data, 'Release Date')) {
                        //  echo "Запись найдена";
                        break 2;
                    }
                }
            }
            $russia = 0;
            $russia = substr_count($data, '(Russia)');// наличие отечественного названия
            if ($russia != 0) {
                // echo "Отечественная дата:<br>";
                if (preg_match('~[[:digit:]]{1,2} [[:alpha:]]{3,9} [[:digit:]]{4}~', $data, $array)) {
                    $date = explode(' ', $array[0]);
                    if($date[0]<10){
                        $date[0]='0'.$date[0];
                    }
                    $data = $date[2] . '-' . $this->dat($date[1]) . '-' . $date[0];
                } else {
                    $data = null;
                }
            } else {
                $data = null;
            }
            return $data;
        }else{
            return null;
        }
    }
    public function parse(Request $request)
    {
        if (isset($request->url)) {
            $flag = 0;
            $url = $request->url;
            $simpleHTML = new Htmldom();
            $all = $simpleHTML->file_get_html($url);
            $release_date=$this->getReleaseImdb($url);
            //поиск картинки
            foreach ($all->find('//*[@id="title-overview-widget"]/div[1]/div[3]/div[1]/a/img') as $link) {
                $image_sourse = $link->src;
            }
            //поиск заголовка

            foreach ($all->find('//*[@id="title-overview-widget"]/div[1]/div[2]/div/div/div[2]/h1') as $link) {
                $title = $link->innertext;
                $title = preg_replace('~<span.*<\/span>~', '', $title);
                if (!preg_match('/[а-я]{3,}/iu', $title)) { //Если название нерусское
                    $flag = 1;
                } else {
                    foreach ($all->find('//*[@id="title-overview-widget"]/div[1]/div[2]/div/div/div[2]/div[1]') as $link) {
                        //*[@id="title-overview-widget"]/div[2]/div[2]/div/div[2]/div[2]/div[1]
                        echo $original = $link->innertext;
                        if($original==null){
                            $original='need Add';
                        }
                    }
                }
            }
            $title = trim($title);
            if ($flag == 1) {// если нерусское
                $original = $title;
            } else {
                $original = preg_replace('~<span.*<\/span>~', '', $original);
            }
            $massData = array('original' => $original,
                'title' => $title,
                'data' => $release_date);
            $original = preg_replace('~[[:punct:]]|[[:space:]]~', '', $original); // очищаем от всякой пунктуации
            if(isset($image_sourse)){
                $pic = $this->getImage($image_sourse, $original); // добываем изображение
                $massData['image'] = $pic;
            }else{
                $massData['image']='NoPoster';
            }

            return view('parseFormImdb', ['massData' => $massData]);
        }
    }
    public   function getImage($url, $title_image)
    {
        $image = $url;
        $mini_title = $title_image;
        if (isset($image)) {
            //$mini_title=$original; //название миниатюры
            define('SOURCE', $image);  // адрес исходный файл
            define('TARGET', 'image/' . $mini_title . '.jpg');     // имя файла для "превьюшки"
            define('NEWX', 182);               // ширина "превьюшки"
            define('NEWY', 268);                // высота "превьюшки"
            // Определяем размер изображения с помощью функции getimagesize:
            $size = getimagesize(SOURCE);
            // Функция getimagesize, требуя в качестве своего параметра имя файла,
            // возвращает массив, содержащий (помимо прочего, о чем можно прочитать
            // в документации), ширину - $size[0] - и высоту - $size[1] -
            // указанного изображения. Кстати, для ее использования не требуется наличие
            // библиотеки GD, так как она работает непосредственно с заголовками
            // графических файлов. В случае, если формат файла не распознан, getimagesize
            // возвращает false:
            if ($size === false) die ('Bad image file!');

            // Читаем в память JPEG-файл с помощью функции imagecreatefromjpeg:
            $source = imagecreatefromjpeg(SOURCE)
            or die('Cannot load original JPEG');

            // Создаем новое изображение
            $target = imagecreatetruecolor(NEWX, NEWY);

            // Копируем существующее изображение в новое с изменением размера:
            imagecopyresampled(
                $target,  // Идентификатор нового изображения
                $source,  // Идентификатор исходного изображения
                0, 0,      // Координаты (x,y) верхнего левого угла
                // в новом изображении
                0, 0,      // Координаты (x,y) верхнего левого угла копируемого
                // блока существующего изображения
                NEWX,     // Новая ширина копируемого блока
                NEWY,     // Новая высота копируемого блока
                $size[0], // Ширина исходного копируемого блока
                $size[1]  // Высота исходного копируемого блока
            );
            // Сохраняем результат в JPEG-файле:
            // Функции генерации графических файлов, такие как imagejpeg,
            // могут выводить результат своей работы не только в броузер,
            // но и в файл. Для этого следует указать имя файла в необязательном
            // втором параметре.
            // Именно функция imagejpeg имеет и третий необязательный параметр -
            // качество изображения. Установим максимальное качество - 100.
            imagejpeg($target, TARGET, 80);
            //$link='http://image.kinopitka.ru/release/previev'.$mini_title.'.jpg';
            $link = 'image/' . $mini_title . '.jpg';
            // Как всегда, не забываем:
            imagedestroy($target);
            imagedestroy($source);
            return $link;
        }
    }
    public function parse_blu_ray($url){
        // $url =  'https://www.dvdsreleasedates.com/movies/7617/the-equalizer-2'; // анонсирован только месяц
        // $url =  'https://www.dvdsreleasedates.com/movies/8026/the-meg'; //анонсирован только DVD без тюнса
        //   $url =  'https://www.dvdsreleasedates.com/movies/7783/ant-man-and-the-wasp'; //все анонсировано
        $simpleHTML = new Htmldom();
        $all = $simpleHTML->file_get_html($url);
        foreach ($all->find('//*[@id="leftcolumn"]/div[2]/div[1]/table/tbody/tr/td[2]/table/tbody/tr[1]/td/h2/span[1]') as $link) {
            $data['dvd'] = $link->innertext;
            $data['dvd'] = preg_replace('~is estimated for~', '', $data['dvd']);
        }
        if ($data['dvd'] == 'not announced') {
            return 0;
            //$data=null;
        } else {
            //поиск DVD
            $data['itunes']=0;
            foreach ($all->find('//*[@id="leftcolumn"]/div[2]/div[1]/table/tbody/tr/td[2]/table/tbody/tr[1]/td/h2/span[2]') as $link) { //поиск цифровой версии
                $itunes_date = $link->innertext;
                if ($itunes_date != 'not announced') {
                    $data['itunes'] = $itunes_date;
                    $data['itunes'] = preg_replace('~is estimated for~', '', $data['itunes']);
                }
            }
        }
        //Фишка с месяцем
        $date['dvd']=$this->otbor($data['dvd']);
        if($data['itunes']!=''){
            $date['itunes']=$this->otbor($data['itunes']);
        }else{
            $date['itunes']=0;
        }
        return $date;
        //  return 0;
    }
    public function otbor($data){//очистка даты
        $mass = explode(',', $data);
        if (isset($mass[1])) {
            $year = $mass[1];
            $temp = explode(' ', $mass[0]);
            $day = $temp[1];
            $month = $temp[0];
            $month = $this->dat($month);
            $date = $year . '-' . $month . '-' . $day;
        } else {
            $temp = explode(' ', $mass[0]);
            $month = $temp[1];
            $month = $this->dat($month);
            $year = $temp[2];
            $day = 23;
            $date = $year . '-' . $month . '-' . $day;
        }
        return $date;
    }
    //обновление DVD релизов
    public function update_Blu_ray(){
        $updated_films =Film::select('id' ,'DVD_release','DVD_source')-> whereBetween('DVD_release',[Carbon::now()->subWeekday(20),Carbon::now()->addMonth(8)])
            ->get();
        foreach ($updated_films as $film){
            if($film->DVD_source!=null){
                $new_date=$this->parse_blu_ray($film->DVD_source);//получение массива спарсенных дат
                if($new_date['dvd']!=0 || $new_date['itunes']!=0){
                    $new_date['dvd']=trim($new_date['dvd']);
                    $new_date['itunes']=trim($new_date['itunes']);
                    if($new_date['dvd']!=$film->DVD_release){
                        //Сделать функцию добавления в новости
                        $film_model=Film::find($film->id);
                        $film_model->DVD_release=$new_date['dvd'];
                        if($new_date['itunes']!=$film->itunes){
                            $film_model->itunes=$new_date['itunes'];
                        }
                        $film_model->save();
                        /*   FilmChange::insert([
                               'film_id'=>$film->id,
                               'DVD_release'=>1
                           ]);*/
                        echo "Дата изменена".$film_model->title."<br>";
                    }else{
                        echo "Даты совпали для".$film->title."<br>";
                        continue;
                    }
                }
            }
        }
        //return redirect('/admin');
    }
    public  function update_imdb(){
        $updated_films =Film::select('id' ,'date_release','imdb')-> whereBetween('date_release',[Carbon::now()->subWeekday(20),Carbon::now()->addMonth(5)])
            ->get();
        //задержка

        foreach ($updated_films as $film){
            echo "Задержка 5 сек <br>";
            //доделать функцию обновления даты
            if($film->imdb!=null){
                $new_date=$this->getReleaseImdb($film->imdb);
                if($new_date!=null){
                    $new_date=trim($new_date);
                    if($new_date!=$film->date_release){
                        //Сделать функцию добавления в новости
                        $film_model=Film::find($film->id);
                        $film_model->date_release=$new_date;
                        $film_model->save();
                        /*   FilmChange::insert([
                               'film_id'=>$film->id,
                               'DVD_release'=>0
                           ]);*/
                        echo "Дата изменена ".$film_model->title." на ".$new_date."<br>";
                    }else{
                        echo "Даты совпали для ".$film->title."<br>";
                        continue;
                    }
                }
            }
        }
    }
    public function parseImage(Request $request){
        $url=$request->url_image;
        $title=$request->title;
        $link= $this->getImage($url,$title);
        echo $link;
    }
    public function parseItunes(){
        $url='https://itunes.apple.com/ru/movie/капитан-марвел/id1454078291';
        $url='https://itunes.apple.com/ru/movie/мстители-финал/id1459467883'; //Мститлели
        $simpleHTML = new Htmldom();
        $all = $simpleHTML->file_get_html($url);
       // foreach ($all->find('.inline-list__item--preorder-media') as $link) {
        foreach ($all->find('span[data-test-price=preorder]') as $link) {
            $data['dvd'] = $link->innertext;
          //  $data['dvd'] = preg_replace('~is estimated for~', '', $data['dvd']);
            dd($data);
        }
    }
}


