@extends('layouts.app')

@section('content')
    <h2 class="text-center mb-4">Список городов</h2>
    <div class="container">
        <div class="alert alert-danger" id="errorSection" style="display: none;">
            <ul>
                <li id="errorText"></li>
            </ul>
        </div>
        <form id="cityForm">
            <div class="form-group">
                <label for="new_city">Название города</label>
                <input type="text" name="name" class="form-control" id="new_city" placeholder="Название города">
            </div>
            <button type="submit" class="btn btn-primary">Добавить новый город</button>
        </form>

        <div class="pagination">
            {{ $cities->links('pagination::bootstrap-4')}}
        </div>

        <div class="row">
            @foreach($cities as $city)
                <div class="col-6 col-md-4 col-lg-2 mb-3"> <!-- 5 columns on large screens -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('city', ['city' => $city['slug']]) }}"
                                   class="{{ isset($selectedCity) && $selectedCity == $city['slug'] ? 'font-weight-bold' : '' }}">
                                    {{ $city['name'] }}
                                </a>
                            </h5>
                            <a href="#" class="text-danger delete-city" data-id="{{ $city['id'] }}">
                                <i class="fas fa-trash"></i>
                            </a>

                        </div>

                    </div>
                </div>
            @endforeach

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {

            $('#cityForm').on('submit', function (event) {

                event.preventDefault();
                var name = $('#new_city').val();

                $.ajax({
                    url: '/api/city',
                    type: 'POST',
                    data: {
                        name: name,
                    },
                    success: function (response) {
                        alert(response.message);
                        $('#new_city').val('');
                        location.reload();
                    },
                    error: function (error) {
                        console.log(error)
                        let errors = error.responseJSON.errors;
                        $('#errorText').text(errors.name[0]);
                        $('#errorSection').show();

                        setTimeout(() => {
                            $('#errorText').text('');
                            $('#errorSection').hide();

                        }, 3000)

                    }
                });
            });

            $('.delete-city').on('click', function (event) {
                event.preventDefault();
                let cityId = $(this).data('id');

                if (confirm('Вы уверены, что хотите удалить город?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/api/city/' + cityId,
                        success: function (response) {
                            alert(response.message);
                            // $(event.target).closest('.col-6').remove();
                            if (response.data.selected_city_removed) {
                                window.location.href = '/';
                            } else {
                                location.reload()
                            }

                        },
                        error: function () {
                            $('#errorText').text('Произошла ошибка. Попробуйте еще раз');
                            $('#errorSection').show();

                            setTimeout(() => {
                                $('#errorText').text('');
                                $('#errorSection').hide();

                            }, 3000)

                        }
                    });
                }
            });


        });
    </script>
@endsection
