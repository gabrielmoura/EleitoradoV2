<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MessageCenter extends Component
{
    public $message = [
//        [
//            'img' => 'assets/img/illustrations/profiles/profile-2.png',
//            'text' => 'Lorem ipsum dolor sit amet, consectetur
//                adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
//                ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
//                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
//                fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui
//                officia deserunt mollit anim id est laborum.',
//            'name' => 'Thomas Wilcox',
//            'time' => '58m',
//        ],
//        [
//            'img' => 'assets/img/illustrations/profiles/profile-3.png',
//            'text' => 'Lorem ipsum dolor sit amet, consectetur
//                adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
//                ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
//                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
//                fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui
//                officia deserunt mollit anim id est laborum.',
//            'name' => 'Emily Fowler',
//            'time' => '2d',
//        ],
//        [
//            'img' => 'assets/img/illustrations/profiles/profile-4.png',
//            'text' => 'Lorem ipsum dolor sit amet, consectetur
//                adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
//                ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
//                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
//                fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui
//                officia deserunt mollit anim id est laborum.',
//            'name' => 'Marshall Rosencrantz',
//            'time' => '3d',
//        ],
    ];

    public function render()
    {
        return view('livewire.message-center', [
            'messages' => $this->message,
        ]);
    }
}
