<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Poster;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'root',
            'email' => 'root@gmail.com',
            'is_admin' => 1,
            'password' => Hash::make('rootroot'),
        ]);

        Poster::create([
            'name' => 'Пассажир',
            'description' => '«Пассажир» - психологический триллер, который держит зрителя в напряжении от начала до конца.

            Фильм рассказывает историю Майкла Макколи, успешного бизнесмена, который возвращается домой из деловой поездки. В поезде он встречает Чарли, странного и таинственного пассажира, который начинает рассказывать ему о своей жизни. Однако, по мере развития разговора, Майкл начинает понимать, что Чарли не тот, за кого себя выдает.
            
            Когда поезд останавливается на одной из станций, Майкл решает покинуть вагон, но Чарли убеждает его остаться, предлагая ему участие в опасной игре. Майкл, не подозревая о последствиях, соглашается, и его жизнь начинает стремительно меняться.',
            'image' => 'posters/1.webp',
            'visibility' => 1
        ]);
        Poster::create([
            'name' => 'За пригоршню долларов',
            'description' => 'В маленьком городке идет война между двумя влиятельными семействами, которых абсолютно не интересует закон. Туда прибывает незнакомец, умеющий стрелять без промаха.',
            'image' => 'posters/2.webp',
            'visibility' => 1
        ]);
        Poster::create([
            'name' => 'Мстители: Эра Альтрона',
            'description' => 'Человечество на грани уничтожения. На этот раз людям угрожает Альтрон — искусственный интеллект, ранее созданный для того, чтобы защищать Землю от любых угроз. Однако, главной угрозой он посчитал человечество. Международная организация Щ.И.Т. распалась, и теперь мир не способен справиться с таким мощным врагом, потому люди вновь обращаются за помощью к Величайшим Героям Земли — Мстителям.',
            'image' => 'posters/16.webp',
            'visibility' => 1
        ]);
        Poster::create([
            'name' => 'Побудь в моей шкуре',
            'description' => 'Каждый день по трассе Эдинбург-Глазго ездит неказистая машина. За рулем — симпатичная брюнетка с огромными зелеными глазами. Она подбирает автостопщиков, в основном здоровых и мощных мужчин, но вовсе не для флирта. Цели девушки куда ужасней.',
            'image' => 'posters/5.webp',
            'visibility' => 1
        ]);
        Poster::create([
            'name' => 'Звёздные войны: Скайуокер. Восход',
            'description' => 'Фильм завершает невероятную историю семьи Скайуокеров, длящуюся уже более сорока лет, и обещает дать ответы на все загадки из предыдущих серий. Зрителя ожидают старые и новые герои, уникальные миры, увлекательные путешествия на край Галактики и грандиозный финал фантастической саги.',
            'image' => 'posters/6.webp',
            'visibility' => 1
        ]);
        Poster::create([
            'name' => 'Амстердам',
            'description' => 'Нью-Йорк, 1933 год. Ветеран Первой мировой Бёрт Берендсен держит небольшую клинику и помогает таким же покалеченным войной бедолагам, как и он сам. ',
            'image' => 'posters/7.webp',
            'visibility' => 1
        ]);
        Poster::create([
            'name' => 'Кей-поп: Последнее прослушивание',
            'description' => 'Молодая девушка Чи Сын-ён обладает нетипичным для девушки характером, а точнее, она - пацанка. Многие даже, по её словам, путают её с Миром. Её мечта — стать легендой хип-хопа. Чтобы её осуществить, она под видом парня присоединяется к мужской айдол-группе. Лидером которой является весьма эгоистичный грубиян Кан У-хён.',
            'image' => 'posters/8.webp',
            'visibility' => 1
        ]);
        Poster::create([
            'name' => 'Сан-Франциско',
            'description' => 'Блейк Нортон высокомерный щеголь - хозяин ночного клуба, пользующегося дурной славой. К нему в бар приходит девушка Мэри Блэйк, приехавшая из провинции, которая отчаялась найти работу. Он соглашается взять ее в качестве певицы, а услышав, как она поет, заключает с ней контракт.',
            'image' => 'posters/9.webp',
            'visibility' => 1
        ]);
    }
}
