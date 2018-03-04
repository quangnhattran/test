<div class="card" v-if="! editing">
    <div class="card-header level">
        <a href="{{ $thread->path() }}" v-text="title">
        
        
        </a>
        
    </div>

    <div class="card-body trix-content" v-html="body">
        
    </div>
    @can('update',$thread)
        <div class="card-footer level">
            <button class="btn btn-sm" @click="editing=true">Edit</button>
        </div>
    @endcan
</div>

<div class="card" v-else v-cloak>
    <div class="card-header level">
        <input type="text" class="form-control" v-model="form.title">
        
    </div>

    <div class="card-body">
{{--          <textarea rows="10" class="form-control" v-model="form.body"></textarea>
  --}}        <wysiwyg v-model="form.body"></wysiwyg>
    </div>
    <div class="card-footer level">
        @can('update',$thread)
            <button class="btn btn-sm btn-primary mr-2" @click="update">Update</button>
            <button class="btn btn-sm" @click="resetForm">Cancel</button>
            <form action="{{ $thread->path() }}" method="post" class=" ml-auto">
                {{ csrf_field() }} {{method_field('delete')}}
                <button class="btn btn-sm ml-auto" type="submit">Delete</button>
            </form>
        @endcan
    </div>
</div>