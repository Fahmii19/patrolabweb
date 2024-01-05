<div id="modalBase" class="d-none">
    <div class="modal fade" id="modalInsertAsset" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Insert Asset to Checkpoint</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('checkpoint-aset-patrol.store')}}" class="form-insert-asset">
                        @csrf
                        @method('post')
                        <input type="hidden" name="asset_id">
                        <div class="mb-3">
                            <label class="form-label">Nama Asset <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_aset') is-invalid @enderror" name="nama_aset" placeholder="Nama Aset" readonly required>
                            @error('nama_aset') <span class="text-danger d-block">{{$message}}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Area</label>
                            <select class="form-select modalArea" name="area" onchange="modal_patrol_area(this)">
                                <option selected value="0">---Semua---</option>
                                @foreach ($area as $item)
                                    <option value="{{ $item->id }}" {{ old('area') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Patrol Area</label>
                            <select class="form-select modalPatrolArea" name="patrol_area" onchange="modal_round(this)">
                                <option selected value="0">---Semua---</option>
                                @foreach ($patrol_area as $item)
                                    <option value="{{ $item->id }}" {{ old('patrol_area') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-danger d-block patrol-area-modal"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Round</label>
                            <select class="form-select modalRound" name="id_round" onchange="modal_checkpoint(this)">
                                <option value="" selected disabled>--Pilih--</option>
                                @foreach ($round as $item)
                                    <option value="{{ $item->id }}" {{ old('id_round') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>  
                            <span class="mt-2 d-block round-modal"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Checkpoint <span class="text-danger">*</span></label>
                            <select class="form-select modalCheckpoint @error('insert_checkpoint') is-invalid @enderror" name="insert_checkpoint" required>
                                <option selected disabled>--Pilih--</option>
                                @foreach ($checkpoint as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="mt-2 d-block checkpoint-modal"></span>
                        </div>

                        <div class="mb-3">
                            <label for="shortDesc" class="form-label">Deskripsi</label>
                            <input type="text" class="form-control @error('short_desc') is-invalid @enderror" name="short_desc" id="shortDesc" placeholder="Deksripsi singkat" required>
                            @error('short_desc') <span class="text-danger d-block">{{$message}}</span> @enderror
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Insert Asset</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <button type="button" data-bs-toggle="modal" id="btnOpenModal" data-bs-target="#insertAsset" class="btn btn-primary">Insert to Checkpoint</button>
</div>