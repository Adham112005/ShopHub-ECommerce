@if ($paginator->hasPages())

<nav class="mt-4">

<ul class="pagination justify-content-center">


{{-- Previous --}}
@if ($paginator->onFirstPage())

<li class="page-item disabled">

<span class="page-link rounded-pill px-4">

<i class="bi bi-chevron-left"></i>
Previous

</span>

</li>

@else

<li class="page-item">

<a class="page-link rounded-pill px-4"
href="{{ $paginator->previousPageUrl() }}">

<i class="bi bi-chevron-left"></i>
Previous

</a>

</li>

@endif




{{-- Numbers --}}

@foreach ($elements as $element)

@if (is_string($element))

<li class="page-item disabled">

<span class="page-link">

{{ $element }}

</span>

</li>

@endif



@if (is_array($element))

@foreach ($element as $page => $url)


@if ($page == $paginator->currentPage())

<li class="page-item active">

<span class="page-link rounded-circle">

{{ $page }}

</span>

</li>


@else


<li class="page-item">

<a class="page-link rounded-circle"
href="{{ $url }}">

{{ $page }}

</a>

</li>


@endif


@endforeach

@endif


@endforeach




{{-- Next --}}

@if ($paginator->hasMorePages())


<li class="page-item">

<a class="page-link rounded-pill px-4"
href="{{ $paginator->nextPageUrl() }}">

Next

<i class="bi bi-chevron-right"></i>

</a>

</li>


@else


<li class="page-item disabled">

<span class="page-link rounded-pill px-4">

Next

<i class="bi bi-chevron-right"></i>

</span>

</li>


@endif



</ul>

</nav>


@endif