<!-- Modal -->
<div class="modal fade" id="popupModal" tabindex="-1" aria-labelledby="popupModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="popupModalLabel">Pop Up Edit</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('settings.popup-update') }}" enctype="multipart/form-data" method="post">
        @method('put')
        @csrf
        <div class="modal-body">
            <input type="text" name="id" id="popupId" hidden>
            <div class="from-group mt-3">
                <label for="popupTitle">Title</label>
                <input type="text" name="title" id="popupTitle" class="form-control">
            </div>
            <div class="from-group mt-3">
                <label for="popupShortDes">Short Description</label>
                <input type="text" name="short_des" id="popupShortDes" class="form-control">
            </div>
            <div class="from-group mt-3">
                <label for="popupImageInput">Image</label>
                <input type="file" name="image" id="popupImageInput" class="form-control">
            </div>
            <img src="" alt="Popup Image" id="popupImage" class="mt-2" style="transform: none; width: 100px;">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
    $(document).on('click', '.popUpEditBtn', function() {
        let id = $(this).data('id');
        let title = $(this).data('title');
        let short_des = $(this).data('short_des');
        let image = $(this).data('image');
        console.log(title);
        $('#popupId').val(id);
        $('#popupTitle').val(title);
        $('#popupShortDes').val(short_des);
        $('#popupImage').attr('src', image);
        $('#popupModal').modal('show');
    });

    const fileInput = document.getElementById('popupImageInput');
    const imagePreview = document.getElementById('popupImage');

    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

</script>