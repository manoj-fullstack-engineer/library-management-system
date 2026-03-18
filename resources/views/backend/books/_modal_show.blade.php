{{-- No @extends or @section here — this is a partial for modal --}}
<div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label><strong>Title:</strong></label>
            <p>{{ $book->title }}</p>
        </div>
        <div class="col-md-6">
            <label><strong>Author:</strong></label>
            <p>{{ $book->author }}</p>
        </div>

        <div class="col-md-6">
            <label><strong>ISBN:</strong></label>
            <p>{{ $book->isbn ?? 'N/A' }}</p>
        </div>
        <div class="col-md-6">
            <label><strong>Publisher:</strong></label>
            <p>{{ $book->publisher ?? 'N/A' }}</p>
        </div>

        <div class="col-md-6">
            <label><strong>Published Date:</strong></label>
            <p>{{ $book->published_date ? $book->published_date->format('d/m/Y') : 'N/A' }}</p>
        </div>
        <div class="col-md-6">
            <label><strong>Category:</strong></label>
            <p>{{ $book->category->name ?? 'N/A' }}</p>
        </div>

        <div class="col-md-6">
            <label><strong>Language:</strong></label>
            <p>{{ $book->language ?? 'N/A' }}</p>
        </div>
        <div class="col-md-6">
            <label><strong>Pages:</strong></label>
            <p>{{ $book->pages ?? 'N/A' }}</p>
        </div>

        <div class="col-md-6">
            <label><strong>Status:</strong></label>
            <p>
                <span class="badge 
                    @switch($book->status)
                        @case('available') bg-success @break
                        @case('issued') bg-warning text-dark @break
                        @case('damaged') bg-danger @break
                        @case('lost') bg-secondary @break
                        @default bg-light text-dark
                    @endswitch
                ">
                    {{ ucfirst($book->status) }}
                </span>
            </p>
        </div>
        <div class="col-md-6">
            <label><strong>Price:</strong></label>
            <p>{{ $book->price ?? 'N/A' }}</p>
        </div>

        <div class="col-12">
            <label><strong>Description:</strong></label>
            <p>{!! nl2br(e($book->description)) ?? 'N/A' !!}</p>
        </div>

        <div class="col-md-6">
            <label><strong>Front Cover:</strong></label><br>
            @if($book->front_cover)
                <img src="{{ asset('storage/' . $book->front_cover) }}" alt="Front Cover" class="img-thumbnail" style="max-width: 150px;">
            @else
                <p>N/A</p>
            @endif
        </div>

        <div class="col-md-6">
            <label><strong>Back Cover:</strong></label><br>
            @if($book->back_cover)
                <img src="{{ asset('storage/' . $book->back_cover) }}" alt="Back Cover" class="img-thumbnail" style="max-width: 150px;">
            @else
                <p>N/A</p>
            @endif
        </div>
    </div>
</div>
