<form action="{{ route('evaluator-evaluate-submit-fail') }}" method="POST" id="failCriteriaFrom">
    @csrf

    @foreach ($questionnaires as $q)
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ $q->title }}
                </div>
                <div class="card-body">
                    @csrf
                        
                    <input type="hidden" name="id" value="{{ $evid }}">
                    <div class="col-12">
                        <div class="bg-danger text-white p-3">
                            @foreach ($q->criterias as $cr)
                                <div class="form-check">
                                    <input name="criteria_id[]" class="form-check-input cr-chk cr-chk-{{ $q->id }}"  data-qid="{{ $q->id }}" type="checkbox" value="{{$cr->id}}" id="cr-{{$cr->id}}" required>
                                    <label class="form-check-label" for="cr-{{$cr->id}}">
                                        {{ $cr->title }}
                                    </label>
                                    </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>
        </div>
    @endforeach
</form>