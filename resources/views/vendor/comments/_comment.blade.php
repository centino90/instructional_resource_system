@inject('markdown', 'Parsedown')
@php
    // TODO: There should be a better place for this.
    $markdown->setSafeMode(true);
@endphp

<div id="comment-{{ $comment->getKey() }}" class="comment-section d-flex border-t border-b my-4 overflow-auto" style="max-height: 400px">
    <img style="max-width: 70px; max-height: 70px" class="img-thumbnail me-3" src="https://www.gravatar.com/avatar/{{ md5($comment->commenter->fname . $comment->commenter->lname) }}.jpg?s=64" alt="{{ $comment->commenter->fname . ' ' . $comment->lname }} Avatar">
    <div>
        <h5 class="mt-0 mb-1">{{ $comment->commenter->fname . ' ' . $comment->commenter->lname }} <small class="text-muted">- {{ $comment->created_at->diffForHumans() }}</small></h5>

        <div>{!! $comment->comment !!}</div>

        <div>
            @can('reply-to-comment', $comment)
                <button data-bs-toggle="modal" data-bs-target="#reply-modal-{{ $comment->getKey() }}" class="btn btn-sm btn-link text-uppercase">@lang('comments::comments.reply')</button>
            @endcan
            @can('edit-comment', $comment)
                <button data-bs-toggle="modal" data-bs-target="#comment-modal-{{ $comment->getKey() }}" class="btn btn-sm btn-link text-uppercase">@lang('comments::comments.edit')</button>
            @endcan
            @can('delete-comment', $comment)
                <a href="{{ route('comments.destroy', $comment->getKey()) }}" onclick="event.preventDefault();confirm('Confirm deletion?') ? document.getElementById('comment-delete-form-{{ $comment->getKey() }}').submit() : '';" class="btn btn-sm btn-link text-danger text-uppercase">@lang('comments::comments.delete')</a>
                <form id="comment-delete-form-{{ $comment->getKey() }}" action="{{ route('comments.destroy', $comment->getKey()) }}" method="POST" style="display: none;">
                    @method('DELETE')
                    @csrf
                </form>
            @endcan
        </div>

        @can('edit-comment', $comment)
            <div class="modal fade" id="comment-modal-{{ $comment->getKey() }}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('comments.update', $comment->getKey()) }}">
                            @method('PUT')
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">@lang('comments::comments.edit_comment')</h5>

                                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="message">@lang('comments::comments.update_your_message_here')</label>
                                    <textarea required class="comment-textarea form-control" name="message" rows="8">{{ $comment->comment }}</textarea>
                                    <small class="form-text text-muted">@lang('comments::comments.markdown_cheatsheet', ['url' => 'https://help.github.com/articles/basic-writing-and-formatting-syntax'])</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-outline-secondary text-uppercase" data-bs-dismiss="modal">@lang('comments::comments.cancel')</button>
                                <button type="submit" class="btn btn-sm btn-outline-success text-uppercase">@lang('comments::comments.update')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan

        @can('reply-to-comment', $comment)
            <div class="modal fade" id="reply-modal-{{ $comment->getKey() }}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('comments.reply', $comment->getKey()) }}">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">@lang('comments::comments.reply_to_comment')</h5>

                                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="message">@lang('comments::comments.enter_your_message_here')</label>
                                    <textarea required class="comment-textarea form-control" name="message" rows="8"></textarea>
                                    <small class="form-text text-muted">@lang('comments::comments.markdown_cheatsheet', ['url' => 'https://help.github.com/articles/basic-writing-and-formatting-syntax'])</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-outline-secondary text-uppercase" data-bs-dismiss="modal">@lang('comments::comments.cancel')</button>
                                <button type="submit" class="btn btn-sm btn-outline-success text-uppercase">@lang('comments::comments.reply')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan

        <br />{{-- Margin bottom --}}

        <?php
            if (!isset($indentationLevel)) {
                $indentationLevel = 1;
            } else {
                $indentationLevel++;
            }
        ?>

        <div class="d-flex flex-column">
        {{-- Recursion for children --}}
        @if($grouped_comments->has($comment->getKey()) && $indentationLevel <= $maxIndentationLevel)
        @php
        $repliedTo = auth()->user()->find($comment->commenter_id);
        @endphp
        <small class="form-text">Replied to: {{!empty($repliedTo) ? $repliedTo->fname . ' ' . $repliedTo->lname : ''}}</small>

            {{-- TODO: Don't repeat code. Extract to a new file and include it. --}}
            @foreach($grouped_comments[$comment->getKey()] as $child)

                @include('comments::_comment', [
                    'comment' => $child,
                    'grouped_comments' => $grouped_comments
                ])
            @endforeach
        @endif
        </div>
    </div>
</div>

{{-- Recursion for children --}}
<div class="d-flex flex-column ">
@if($grouped_comments->has($comment->getKey()) && $indentationLevel > $maxIndentationLevel)
@php
$repliedTo = auth()->user()->find($comment->commenter_id);
@endphp
<small class="form-text">Replied to: {{$repliedTo->fname . ' ' . $repliedTo->lname}}</small>
    {{-- TODO: Don't repeat code. Extract to a new file and include it. --}}
    @foreach($grouped_comments[$comment->getKey()] as $child)
        @include('comments::_comment', [
            'comment' => $child,
            'grouped_comments' => $grouped_comments
        ])
    @endforeach
@endif
</div>
