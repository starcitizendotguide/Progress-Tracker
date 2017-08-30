@extends('layouts.manage')

@section('content')
    <nav class="breadcrumb is-centered" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('manage.content.tasks') }}">Overview</a></li>
            <li class="is-active"><a href="#">{{ $task->name }} [Standalone Task]</a></li>
        </ul>
    </nav>
    <b-tabs v-model="activeTab" position="is-centered" expanded class="block">
        <b-tab-item label="Task">
            <form class="form" action="{{ route('manage.content.tasks.edit.update_standalone', ['id' => $task->id]) }}" method="POST">

                {{ csrf_field() }}

                <div class="field">
                    <label class="label">Name</label>
                    <p class="control">
                        <input class="input" type="text" name="name" value="{{ old('name', $task->name) }}">
                    </p>
                    @if ($errors->has('name'))
                        <p class="help is-danger">{{ $errors->first('name') }}</p>
                    @endif
                </div>

                <div class="field">
                    <label class="label">Description</label>
                    <p class="control">
                        <textarea class="textarea" type="text" name="description">{{ old('description', $task->description) }}</textarea>
                    </p>
                    @if ($errors->has('description'))
                        <p class="help is-danger">{{ $errors->first('description') }}</p>
                    @endif
                </div>

                <div class="field is-grouped is-grouped-centered">
                    <div class="field">
                        <label class="label">Status<label>
                        <p class="control">
                            <div class="select">
                                <select name="status">
                                    @foreach ($statuses as $status)
                                        @if (old('status', $task->status) == $status->id)
                                              <option value="{{ $status->id }}" selected>{{ $status->name }}</option>
                                        @else
                                              <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </p>
                        @if ($errors->has('type'))
                            <p class="help is-danger">{{ $errors->first('type') }}</p>
                        @endif
                    </div>

                    <div class="field">
                        <label class="label">Type<label>
                        <p class="control">
                            <div class="select">
                                <select name="type">
                                    @foreach ($types as $type)
                                        @if (old('type', $task->type) == $type->id)
                                              <option value="{{ $type->id }}" selected>{{ $type->name }}</option>
                                        @else
                                              <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </p>
                        @if ($errors->has('type'))
                            <p class="help is-danger">{{ $errors->first('type') }}</p>
                        @endif
                    </div>

                    <div class="field">
                        <label class="label">Progress<label>
                        <p class="control">
                            <div>
                                <input class="input" type="number" step=any name="progress" value="{{ old('progress', $task->progress * 100) }}">
                            </div>
                        </p>
                        @if ($errors->has('progress'))
                            <p class="help is-danger">{{ $errors->first('progress') }}</p>
                        @endif
                    </div>
                </div>
                <button class="button is-primary is-outlined is-fullwidth m-t-5">Update</button>
            </form>
        </b-tab-item>

        <b-tab-item label="Sources">
            <manage-sources-item objectid="{{ $task->id }}" standalone="true"></manage-sources-item>
            <a href="{{ route('manage.content.source.create', ['id' => $task->id, 'standalone' => $task->standalone]) }}" class="button is-primary is-outlined is-fullwidth m-t-5">Add New Source</a>
        </b-tab-item>

    </b-tabs>
@endsection