@if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
    <a class="nav-link{{ App\Helpers\AppHelper::getActiveClass('courses*') }}" href="{{ URL::route('course.index', []) }}">Курсы</a>
    <a class="nav-link{{ App\Helpers\AppHelper::getActiveClass('groups*') }}" href="{{ URL::route('group.index', []) }}">Группы</a>
    <a class="nav-link{{ App\Helpers\AppHelper::getActiveClass('student*') }}" href="{{ URL::route('student.index', []) }}">Студенты</a>
@endif
<a class="nav-link{{ App\Helpers\AppHelper::getActiveClass('labs*') }}" href="{{ URL::route('lab.index', []) }}">Лабораторные</a>
<a class="nav-link{{ App\Helpers\AppHelper::getActiveClass('lab-student-exes*') }}" href="{{ URL::route('labstudentexe.index', []) }}">Выполнение</a>
@if(Auth::user()->isAdmin())
    <a class="nav-link dropdown-toggle{{ App\Helpers\AppHelper::getActiveClass('users*') }}" href="{{ URL::route('user.index', []) }}" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Пользователи
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="{{ URL::route('user.index', []) }}">Все</a>
        <a class="dropdown-item" href="{{ URL::route('user.index', ['role' => App\User::STUDENT_ROLE]) }}">Студент</a>
        <a class="dropdown-item" href="{{ URL::route('user.index', ['role' => App\User::TEAHCER_ROLE]) }}">Преподаватели</a>
        <a class="dropdown-item" href="{{ URL::route('user.index', ['role' => App\User::ADMIN_ROLE]) }}">Админы</a>
    </div>
@endif