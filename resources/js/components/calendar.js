(function () {

$(document).ready(function(e) {

    

    if ($("#calendar").length > 0 ) {

        // General variables
        var WEBROOT = $('#WEBROOT').val(),
            userId = document.getElementById('userId').value;
        // Calendar variables
        var monthName = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            currentDate = new Date(),
            currentDay = document.getElementById('day').value,
            currentMonth = document.getElementById('month').value - 1,
            currentYear = document.getElementById('year').value,
            btnCalendarDelete = document.getElementById('btnCalendarDelete'),
            monthLast = $('#monthLast'),
            yearLast = $('#yearLast'),
            monthNext = $('#monthNext'),
            yearNext = $('#yearNext'),
            btnLastMonth = $('#btnLastMonth'),
            btnNextMonth = $('#btnNextMonth'),
            dayForMonth = $('#dayForMonth'),
            days = 1,
            dayNewMonth = 1,
            fullScreenPhoto = $("#fullScreenPhoto"),
            cMonth = $(".currentMonth"),
            cYear = $(".currentYear"),
            newPhoto = $('#newPhoto'),
            modalCalendarDelete = $("#modalCalendarDelete"),
            formCalendarDelete = document.getElementById('formCalendarDelete'),
            formNewPhoto = document.getElementById('formNewPhoto');
            var rialDate = document.getElementById('date').value;

        var my_user = $('#my_user').val();
        if (!(my_user == userId)) {
            btnCalendarDelete.classList.add('d-none');
        } else {
            $( "#btnDelete" ).click(function() {
                axios.post
                ('/calendar/delete', {fecha: formCalendarDelete.fecha.value, _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')})
                    .then(function (response) {
                        if(response.data.length > 0){
                            $('#my-heart').html(response.data);



                        }
                    })
                    .catch(function (error) {

                    })
                    .then(function () {
                        //$('.modal-backdrop').remove();
                        location.reload();
                        //TODO: revisar como borrar sin redireccionar
                        /* var ic = document.createElement('i');
                        var icla = document.createAttribute('class');
                        icla.value = "fas fa-plus";
                        ic.setAttributeNode(icla);
                        var btn = document.createElement('button');
                        var clas = document.createAttribute('class');
                        clas.value = "btnC waves-effect cv-1 bounceIn";
                        var type = document.createAttribute('type');
                        type.value = "button";
                        var data = document.createAttribute('data-id');
                        data.value = formCalendarDelete.fecha.value;
                        var dataToggle = document.createAttribute('data-toggle');
                        dataToggle.value = "modal";
                        var dataTarget = document.createAttribute('data-target');
                        dataTarget.value = "#loadPhoto";
                        btn.setAttributeNode(clas);
                        btn.setAttributeNode(type);
                        btn.setAttributeNode(data);
                        btn.setAttributeNode(dataToggle);
                        btn.setAttributeNode(dataTarget);
                        btn.appendChild(ic);
                        btn.addEventListener('click', function() {
                            var viewDate = document.getElementById("fechaParaSurbirFoto");
                            viewDate.innerText = "Fecha: " + this.attributes[2].value[8] + this.attributes[2].value[9] + " de " + monthName[parseInt(this.attributes[2].value[5] + this.attributes[2].value[6]) - 1] + " de " + this.attributes[2].value[0] + this.attributes[2].value[1] + this.attributes[2].value[2] + this.attributes[2].value[3];
                            var dateRial = document.getElementById('newPhotoCalendarDate');
                            var att = document.createAttribute('value');
                            att.value = this.attributes[2].value;
                            dateRial.setAttributeNode(att);
                        });
                        document.getElementById(formCalendarDelete.fecha.value).innerHTML = '';
                        document.getElementById(formCalendarDelete.fecha.value).appendChild(btn);
                        fullScreenPhoto.modal('toggle');
                        modalCalendarDelete.modal('toggle'); */
                    });

            });
        }

        $('#loadPhoto').on('hidden.bs.modal', function (e) {
            $('.calendar-error').hide();
        });

        $( "#formNewPhoto" ).submit(function( event ) {
            event.preventDefault();
            let myForm = document.getElementById('formNewPhoto');
            let formData = new FormData(myForm);
            $('#spinner-calendar').show();
            $('.calendar-error').hide();
            axios.post
            ('/calendar/insert', formData)
                .then(function (response) {
                    
                    //location.reload();

                    $('#spinner-calendar').hide();
                    $('#loadPhoto').modal('hide');
                   
                    if(response.data.length > 0){
                      /*   $('#my-heart').html(response.data);
                        $('#loadrewards').modal('show'); */
                        location.href = '/perfil?recompensa=true&corazones='+response.data;
                    }else{
                        location.reload();
                    }

                    $('.avatar-pic').attr('src', '/img/logos/nubewhite.png');

                    /*for (let i = 0; i < response.data.length; i++) {
                        $('#'+response.data[i]).addClass('animated bounceInUp  border-red');
                    }*/
                    $('#formNewPhoto').trigger("reset");

                    $('#loadPhoto').modal('hide');
                    $('.modal-backdrop').remove();
                    /*if(response.data.length > 0){
                        Swal.fire({
                            type: 'error',
                            html: 'llena tus semanas para cobrar tus <i class="fas fa-heart heart-small text-danger"></i>',
                        })
                    }*/

                })
                .catch(function (error) {
                    var result = error.response.data;
                    var errors = result.errors;
                    $('.calendar-error').show();
                    $('#spinner-calendar').hide();
                    for (var k in errors){
                        if (typeof errors[k] !== 'function') {
                            $('.'+k).html(errors[k]);
                            $('#'+k).addClass('is-invalid');

                        }
                    }
                })
                .then(function () {
                    loadPhoto($('#newPhotoCalendarDate').val());
                });

        });

        $( "#btnCalendarDelete" ).click(function() {
            modalCalendarDelete.modal('show');
        });

        newPhoto.on('change', function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var photo = e.target.result;
                    $('#contentPhotoCalendar').html("<img src='" + photo + "' class='z-depth-1-half avatar-pic rounded-circle' alt='Foto de perfil'>");
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        new WOW().init();

        writeDate();

        writeMonth(currentMonth);

        btnLastMonth.on('click', function(e) {
            lastMonth();
            $('.contentImg').addClass('animated bounceInUp faster');
            $('.contentImg').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend');
        });

        btnNextMonth.on('click', function(e) {
            nextMonth();
            $('.contentImg').addClass('animated bounceInDown faster');
            $('.contentImg').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend');
        });

        function zoomPhoto() {
            itemFullScreen = $(".clickImg");

            itemFullScreen.on("click", function(e) {

                fullScreenPhoto.removeClass("animated zoomOut zoomIn faster");

                var img = $(this).children("img");

                if (img.length == 1) {
                    var image = img.attr("data-image");
                    formCalendarDelete.fecha.value = img[0].attributes[0].value;
                    btnCalendarDelete.attributes[2].value = img[0].attributes[0].value;

                    $('#photo-full').attr('src', image);
                    fullScreenPhoto.addClass("animated zoomIn faster");
                    fullScreenPhoto.modal('show');
                }
            });
        }

        function getTotalDays(month) {
            if (month == -1) month = 11;

            if (month == 0 || month == 2 || month == 4 || month == 6 || month == 7 || month == 9 || month == 11) {
                return 31;
            } else if (month == 3 || month == 5 || month == 8 || month == 10) {
                return 30;
            } else {
                return isLeap() ? 29 : 28;
            }
        }

        function isLeap() {
            return ((currentYear % 100 !== 0) && (currentYear % 4 === 0) || (currentYear % 400 === 0));
        }

        function startDay() {
            var start = new Date(currentYear, currentMonth, 1);
            return ((start.getDay() - 1) === -1) ? 6 : start.getDay() - 1;
        }

        function lastMonth() {
            if (currentMonth !== 0) {
                currentMonth--;
            } else {
                currentMonth = 11;
                currentYear--;
            }
            setNewDate();
        }

        function nextMonth() {
            if (currentMonth !== 11) {
                currentMonth++;
            } else {
                currentMonth = 0;
                currentYear++;
            }
            setNewDate();
        }

        function setNewDate() {
            currentDate.setFullYear(currentYear, currentMonth, currentDay);
            writeDate();
            writeMonth(currentMonth);
        }

        function writeDate() {
            if (currentMonth == 11) {
                monthNext.html(monthName[0]);
                yearNext.html(currentYear + 1);
            } else {
                monthNext.html(monthName[currentMonth + 1]);
                yearNext.html(currentYear);
            }

            if (currentMonth == 0) {
                monthLast.html(monthName[11]);
                yearLast.html(currentYear - 1);
            } else {
                yearLast.html(currentYear);
                monthLast.html(monthName[currentMonth - 1]);
            }

            cMonth.html(monthName[currentMonth]);
            cYear.html(currentYear);
        }

        function writeMonth(month) {
            var listDates = [];
            days = 1, dayNewMonth = 1, lMonth = currentMonth, lYear = currentYear, nMonth = currentMonth + 1, nYear = currentYear;
            dayForMonth.html('');
            if (lMonth == 0) {
                lMonth = 12;
                lYear--;
            }
            if (nMonth == 12) {
                nMonth = 0;
                nYear++;
            }
            for (var i = startDay(); i > 0; i--) {
                dateLast = lYear + "-" + ((lMonth < 10) ? "0" + lMonth : lMonth) + "-" + (getTotalDays(lMonth - 1) - (i - 1));

                dayForMonth.html(dayForMonth.html() + `
                        <div class='calendarDay itenCalendar contentImgCalendar'>
                            <div class="monthLn contentImg cv-1 clickImg font" data-id="${dateLast}" id="${dateLast}">
                            </div>
                        </div>`);

                if (days == 7) {
                    days = 1;
                } else {
                    days++;
                }

                listDates.push(dateLast);
            }
            for (var i = 1; i <= getTotalDays(month); i++) {
                dateCurrent = currentYear + '-' + ((currentMonth + 1) < 10 ? "0" + (currentMonth + 1) : currentMonth + 1) + '-' + (i < 10 ? "0" + i : i);
                dayForMonth.html(dayForMonth.html() + `
                        <div class='calendarDay itenCalendar contentImgCalendar'>
                            <div class="text-center contentImg cv-1 clickImg" data-id="${dateCurrent}" id="${dateCurrent}">
                            </div>
                        </div>`);

                if (days == 7) {
                    days = 1;
                } else {
                    days++;
                }

                listDates.push(dateCurrent);
            }

            if (days == 1) {
                days = 8;
            }

            for (var i = days; i <= 7; i++) {
                dateNext = nYear + "-" + ((nMonth + 1) < 10 ? "0" + (nMonth + 1) : nMonth + 1) + "-" + (dayNewMonth < 10 ? "0" + dayNewMonth : dayNewMonth);
                dayForMonth.html(dayForMonth.html() + `
                        <div class='calendarDay itenCalendar contentImgCalendar'>
                            <div class="monthLn contentImg cv-1 font" data-id="${dateNext}" id="${dateNext}">
                            </div>
                        </div>`);

                dayNewMonth++;

                listDates.push(dateNext);
            }

            zoomPhoto();
            userCalendar(listDates);
        }

        $('.contentImg').addClass('animated bounceIn');
        $('.contentImg').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend');

        function userCalendar(dates) {

            axios.get
            ('/api/profiler/loadCalendar?date_in='+dates[0]+'&date_fin='+dates[dates.length - 1]+ '&userId='+userId)
                .then(function (response) {
                    var result = JSON.stringify(response.data);
                    localStorage.setItem('calendar',result);
                    loadbp(dates);
                })
                .catch(function (error) {
                })
                .then(function () {
                });

        }

        function loadPhoto(date) {
            axios.post
            ('/profiler/loadPhoto', {fecha: date, _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')})
                .then(function (response) {
                    var result = response.data;
                    $('#'+result.photo.fpublicacion).removeClass('border-red');
                    var img = $('<img />', {
                        'id': result.photo.fpublicacion,
                        'src': '/img/profile/'+result.myUserId+'/calendar/thumb-'+result.photo.photo,
                        'alt': result.photo.fpublicacion[8] + result.photo.fpublicacion[9],
                        'data-image': '/img/profile/'+result.myUserId+'/calendar/'+result.photo.photo,
                        'class': 'calendarHomer bounceIn img-calendar',

                    });
                    document.getElementById(result.photo.fpublicacion).innerHTML = '';
                    img.appendTo($('#'+result.photo.fpublicacion));
                })
                .catch(function (error) {

                })
                .then(function () {
                });


        }

        function loadbp(dates) {
            var photos = JSON.parse(localStorage.getItem('calendar'));
            //var photos = dates;
            for (var i = 0; i < dates.length; i++) {
                if (dates[i] < rialDate) {
                    if (photos[1] == userId) {
                        var ic = document.createElement('i');
                        var icla = document.createAttribute('class');
                        icla.value = "fas fa-plus";
                        ic.setAttributeNode(icla);
                        var btn = document.createElement('button');
                        var clas = document.createAttribute('class');
                        clas.value = "btnC waves-effect cv-1 bounceIn";
                        var type = document.createAttribute('type');
                        type.value = "button";
                        var data = document.createAttribute('data-id');
                        data.value = dates[i];


                        var dataToggle = document.createAttribute('data-toggle');
                        dataToggle.value = "modal";
                        var dataTarget = document.createAttribute('data-target');
                        dataTarget.value = "#loadPhoto";
                        btn.setAttributeNode(clas);
                        btn.setAttributeNode(type);
                        btn.setAttributeNode(data);
                        btn.setAttributeNode(dataToggle);
                        btn.setAttributeNode(dataTarget);
                        btn.appendChild(ic);
                        btn.addEventListener('click', function() {

                            $('#newPhotoCalendarDate').val(this.attributes[2].value);
                            $('#fechaParaSurbirFoto').html("" + this.attributes[2].value[8] + this.attributes[2].value[9] + " de " + monthName[parseInt(this.attributes[2].value[5] + this.attributes[2].value[6]) - 1] + " de " + this.attributes[2].value[0] + this.attributes[2].value[1] + this.attributes[2].value[2] + this.attributes[2].value[3]);

                        });
                        document.getElementById(dates[i]).appendChild(btn);
                    } else {
                        var p = document.createElement('p');
                        var txt = document.createTextNode(dates[i][8] + dates[i][9]);
                        var att = document.createAttribute('class');
                        att.value = 'text-lighter dayCalendar bounceIn';
                        p.setAttributeNode(att);
                        p.appendChild(txt);
                        document.getElementById(dates[i]).appendChild(p);
                    }
                } else if (dates[i] > rialDate) {
                    var p = document.createElement('p');
                    var txt = document.createTextNode(dates[i][8] + dates[i][9]);
                    var att = document.createAttribute('class');
                    att.value = 'text-lighter dayCalendar bounceIn';
                    p.setAttributeNode(att);
                    p.appendChild(txt);
                    document.getElementById(dates[i]).appendChild(p);
                } else {
                    if (photos[1] == userId) {
                        var ic = document.createElement('i');
                        var icla = document.createAttribute('class');
                        icla.value = "fas fa-plus";
                        ic.setAttributeNode(icla);
                        var btn = document.createElement('button');
                        var clas = document.createAttribute('class');
                        clas.value = "btnC waves-effect cv-1 bounceIn";
                        var type = document.createAttribute('type');
                        type.value = "button";
                        var data = document.createAttribute('data-id');
                        data.value = dates[i];
                        var dataToggle = document.createAttribute('data-toggle');
                        dataToggle.value = "modal";
                        var dataTarget = document.createAttribute('data-target');
                        dataTarget.value = "#loadPhoto";
                        btn.setAttributeNode(clas);
                        btn.setAttributeNode(type);
                        btn.setAttributeNode(data);
                        btn.setAttributeNode(dataToggle);
                        btn.setAttributeNode(dataTarget);
                        btn.appendChild(ic);
                        btn.addEventListener('click', function() {
                            var viewDate = document.getElementById("fechaParaSurbirFoto");
                            viewDate.innerText = "Fecha: " + this.attributes[2].value[8] + this.attributes[2].value[9] + " de " + monthName[parseInt(this.attributes[2].value[5] + this.attributes[2].value[6]) - 1] + " de " + this.attributes[2].value[0] + this.attributes[2].value[1] + this.attributes[2].value[2] + this.attributes[2].value[3];
                            var dateRial = document.getElementById('newPhotoCalendarDate');
                            var att = document.createAttribute('value');
                            att.value = this.attributes[2].value;
                            dateRial.setAttributeNode(att);
                            document.getElementById('photoCalendar').classList.add("none");
                            document.getElementById('contentPhotoCalendar').innerHTML = `<img src="https://mdbootstrap.com/img/Photos/Others/placeholder-avatar.jpg" class="z-depth-1-half avatar-pic" alt="Foto de perfil">`;
                        });
                        document.getElementById(dates[i]).appendChild(btn);
                    } else {
                        var p = document.createElement('p');
                        var txt = document.createTextNode(dates[i][8] + dates[i][9]);
                        var att = document.createAttribute('class');
                        att.value = 'text-lighter dayCalendar bounceIn';
                        p.setAttributeNode(att);
                        p.appendChild(txt);
                        document.getElementById(dates[i]).appendChild(p);
                    }
                }
            }

            for (var i = 0; i < photos[0].length; i++) {
                var img = document.createElement('img');
                var src = document.createAttribute('src');
                src.value = WEBROOT + "img/profile/"+$('#userId').val()+"/"+"calendar/thumb-" +  photos[0][i].photo;
                var alt = document.createAttribute('alt');
                alt.value = photos[0][i].fpublicacion[8] + photos[0][i].fpublicacion[9];
                var cla = document.createAttribute('class');
                cla.value = "calendarHomer bounceIn img-calendar";
                var dataId = document.createAttribute('data-id');
                dataId.value = photos[0][i].fpublicacion;

                var dataImage = document.createAttribute('data-image');
                dataImage.value = WEBROOT + "img/profile/"+$('#userId').val()+"/"+"calendar/" +  photos[0][i].photo;
                img.setAttributeNode(dataId);
                img.setAttributeNode(src);
                img.setAttributeNode(alt);
                img.setAttributeNode(cla);
                img.setAttributeNode(dataImage);
                document.getElementById(photos[0][i].fpublicacion).innerHTML = ``;
                document.getElementById(photos[0][i].fpublicacion).append(img);
            }
        }
    }
});
})();
