<?php

use Illuminate\Database\Seeder;

class CategoriesMenu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu_item = new \App\CategoriesMenu([
            'parent_id' => '0',
            'name' => 'literature',
            'title' => 'Художественная литература',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        $menu_item->save();

        $menu_item = new \App\CategoriesMenu([
            'parent_id' => '0',
            'name' => 'spirituality-health',
            'title' => 'Духовный мир и здоровье',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        $menu_item->save();

        $menu_item = new \App\CategoriesMenu([
            'parent_id' => '0',
            'name' => 'science-technology',
            'title' => 'Наука и технологии',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        $menu_item->save();

        $menu_item = new \App\CategoriesMenu([
            'parent_id' => '0',
            'name' => 'education',
            'title' => 'Учебники и образование',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        $menu_item->save();

        $menu_item = new \App\CategoriesMenu([
            'parent_id' => '1',
            'name' => 'classic',
            'title' => 'Классическая литература',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        $menu_item->save();

        $menu_item = new \App\CategoriesMenu([
            'parent_id' => '1',
            'name' => 'modern',
            'title' => 'Современная проза',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        $menu_item->save();

        $menu_item = new \App\CategoriesMenu([
            'parent_id' => '1',
            'name' => 'science-fantasy-mysticism',
            'title' => 'Фантастика. Фэнтези. Мистика',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        $menu_item->save();

        $menu_item = new \App\CategoriesMenu([
            'parent_id' => '1',
            'name' => 'adventure-detective',
            'title' => 'Приключения и детектив',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        $menu_item->save();

        $menu_item = new \App\CategoriesMenu([
            'parent_id' => '1',
            'name' => 'historical',
            'title' => 'Историческая литература',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        $menu_item->save();

        $menu_item = new \App\CategoriesMenu([
            'parent_id' => '2',
            'name' => 'medicine-health',
            'title' => 'Медицина и здоровье',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        $menu_item->save();

        $menu_item = new \App\CategoriesMenu([
            'parent_id' => '2',
            'name' => 'beauty-fashion',
            'title' => 'Красота и стиль',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        $menu_item->save();

        $menu_item = new \App\CategoriesMenu([
            'parent_id' => '2',
            'name' => 'art-culture',
            'title' => 'Искусство и культура',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        $menu_item->save();

        $menu_item = new \App\CategoriesMenu([
            'parent_id' => '2',
            'name' => 'religion-esoterica',
            'title' => 'Религия. Оккультизм. Эзотерика',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        $menu_item->save();

        $menu_item = new \App\CategoriesMenu([
            'parent_id' => '3',
            'name' => 'exact-science',
            'title' => 'Точные науки',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        $menu_item->save();

        $menu_item = new \App\CategoriesMenu([
            'parent_id' => '3',
            'name' => 'biology',
            'title' => 'Биология и анатомия',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        $menu_item->save();

        $menu_item = new \App\CategoriesMenu([
            'parent_id' => '3',
            'name' => 'philosophy-sociology',
            'title' => 'Философия и социология',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        $menu_item->save();

        $menu_item = new \App\CategoriesMenu([
            'parent_id' => '3',
            'name' => 'history',
            'title' => 'История',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        $menu_item->save();

        $menu_item = new \App\CategoriesMenu([
            'parent_id' => '3',
            'name' => 'architecture',
            'title' => 'Архитектура и строительство',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        $menu_item->save();

        $menu_item = new \App\CategoriesMenu([
            'parent_id' => '3',
            'name' => 'military',
            'title' => 'Военное дело',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        $menu_item->save();

        $menu_item = new \App\CategoriesMenu([
            'parent_id' => '4',
            'name' => 'languages',
            'title' => 'Иностранные языки',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        $menu_item->save();

        $menu_item = new \App\CategoriesMenu([
            'parent_id' => '4',
            'name' => 'higher',
            'title' => 'Учебники для вузов',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        $menu_item->save();

        $menu_item = new \App\CategoriesMenu([
            'parent_id' => '4',
            'name' => 'secondary',
            'title' => 'Средняя школа',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        $menu_item->save();

        $menu_item = new \App\CategoriesMenu([
            'parent_id' => '4',
            'name' => 'primary',
            'title' => 'Дошкольное образование',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        $menu_item->save();
    }
}
