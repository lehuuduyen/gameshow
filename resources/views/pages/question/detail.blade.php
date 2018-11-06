@extends('master')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Câu hỏi: {{ $question->content }}</h3>
        </div>
        <form action="{{ route('answer.store') }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" value="{{ $question->id }}" name="question_id" />
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="tag_0">Video Intro</label>
                            <input type="file" name="tag_0">
                            @if($tag_0 = $question->answers->where('tag', 0)->first())
                                <output>
                                    <span>
                                        @if (in_array(pathinfo($tag_0->path, PATHINFO_EXTENSION), [
                                            'mp4', 'avi', 'mov', 'flv', 'swf', 'mpeg', 'webm'
                                        ]))
                                            <video width="320" height="240" controls>
                                              <source src="{{ url($tag_0->path) }}" >
                                            </video>
                                        @else
                                            <img src="{{ url($tag_0->path) }}" width="320">
                                        @endif
                                    </span>
                                </output>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tag_1">Video câu hỏi</label>
                            <input type="file" name="tag_1">
                            @if($tag_1 = $question->answers->where('tag', 1)->first())
                                <output>
                                    <span>
                                        @if (in_array(pathinfo($tag_1->path, PATHINFO_EXTENSION), [
                                            'mp4', 'avi', 'mov', 'flv', 'swf', 'mpeg', 'webm'
                                        ]))
                                            <video width="320" height="240" controls>
                                              <source src="{{ url($tag_1->path) }}" >
                                            </video>
                                        @else
                                            <img src="{{ url($tag_1->path) }}" width="320">
                                        @endif
                                    </span>
                                </output>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tag_2">Video đáp án</label>
                            <input type="file" name="tag_2">
                            @if($tag_2 = $question->answers->where('tag', 2)->first())
                                <output>
                                    <span>
                                        @if (in_array(pathinfo($tag_2->path, PATHINFO_EXTENSION), [
                                            'mp4', 'avi', 'mov', 'flv', 'swf', 'mpeg', 'webm'
                                        ]))
                                            <video width="320" height="240" controls>
                                              <source src="{{ url($tag_2->path) }}" >
                                            </video>
                                        @else
                                            <img src="{{ url($tag_2->path) }}" width="320">
                                        @endif
                                    </span>
                                </output>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tag_3">Video giải thích</label>
                            <input type="file" name="tag_3">
                            @if($tag_3 = $question->answers->where('tag', 3)->first())
                                <output>
                                    <span>
                                        @if (in_array(pathinfo($tag_3->path, PATHINFO_EXTENSION), [
                                            'mp4', 'avi', 'mov', 'flv', 'swf', 'mpeg', 'webm'
                                        ]))
                                            <video width="320" height="240" controls>
                                              <source src="{{ url($tag_3->path) }}" >
                                            </video>
                                        @else
                                            <img src="{{ url($tag_3->path) }}" width="320">
                                        @endif
                                    </span>
                                </output>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tag_4">Mask (trắng đen)</label>
                            <input type="file" name="tag_4">
                            @if($tag_4 = $question->answers->where('tag', 4)->first())
                                @if($tag_4->path)
                                    <output>
                                        <span>
                                            @if (in_array(pathinfo($tag_4->path, PATHINFO_EXTENSION), [
                                                'mp4', 'avi', 'mov', 'flv', 'swf', 'mpeg', 'webm'
                                            ]))
                                                <video width="320" height="240" controls>
                                                  <source src="{{ url($tag_4->path) }}" >
                                                </video>
                                            @else
                                                <img src="{{ url($tag_4->path) }}" width="320">
                                            @endif
                                        </span>
                                    </output>
                                @endif
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="url">URL</label>
                            <input type="text" name="url" class="form-control" value="{{ isset($tag_4->url) ? URL($tag_4->url) : '' }}" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-success pull-right">Lưu</button>
            </div>
        </form>
        <!-- /.box-footer-->
    </div>
@endsection

@push('script')

@endpush