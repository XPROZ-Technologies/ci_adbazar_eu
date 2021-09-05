$(document).ready(function () {
   
    var siteName = $('input#siteName').val();
    if (siteName != '') {
        siteName = $('title').text() + ' - ' + siteName;
        $('title').text(siteName);
        $('input#siteName').val(siteName);
    }
    if ($('select.select2').length > 0) {
        $('select.select2').select2({
            placeholder: $(this).attr('placeholder')
        });
    }
    if ($('div.divTable').length > 0) {
        if ($(window).width() > 760) $('div.divTable').removeClass('table-responsive');
        else $('div.divTable').addClass('table-responsive');
        $(window).resize(function () {
            if ($(window).width() > 760) $('div.divTable').removeClass('table-responsive');
            else $('div.divTable').addClass('table-responsive');
        });
    }
    $(document).ajaxStart(function () {
        Pace.restart();
    });

    //admin menu
    if ($('.sidebar-menu').length > 0) {
        var curentPathName = window.location.pathname;
        var rootPath = $('input#rootPath').val();
        curentPathName = curentPathName.replace(rootPath, '');
        var hostname = window.location.hostname;
        $('.sidebar-menu li a').each(function () {
            var pageLink = $(this).attr('href');
            if (pageLink != undefined) {
                pageLink = pageLink.replace('https://', '');
                pageLink = pageLink.replace('http://', '');
                pageLink = pageLink.replace(hostname, '');
                pageLink = pageLink.replace(rootPath, '');
                if (pageLink == curentPathName) {
                    $(this).parent('li').addClass('active');
                    var ul = $(this).parent('li').parent('ul').parent('li').parent('ul');
                    if (ul.length > 0) {
                        $(this).parent('li').parent('ul').css('display', 'block');
                        $(this).parent('li').parent('ul').parent('li').addClass('active');
                        ul.css('display', 'block');
                        ul.parent('li').addClass('active');
                    }
                    else $(this).parent('li').parent('ul').parent('li').addClass('active');
                    return false;
                }
            }
        });
        if(localStorage.getItem('hkrep_menu_collapsed') == '1') $('body').addClass('sidebar-collapse');
        else $('body').removeClass('sidebar-collapse');
        $('.sidebar-toggle').click(function (e) {
            e.preventDefault();
            if(localStorage.getItem('hkrep_menu_collapsed') == '1') localStorage.setItem('hkrep_menu_collapsed', '0');
            else localStorage.setItem('hkrep_menu_collapsed', '1');
        });
        $('section.sidebar').slimScroll({
            height: ($(document).height() - 30) + 'px',
            color : '#2C3B41'
        });
    }
});

function replaceCost(cost, isInt) {
    cost = cost.replace(/\,/g, '');
    if (cost == '') cost = 0;
    if (isInt) return parseInt(cost);
    else  return parseFloat(cost);
}

function formatDecimal(value) {
    value = value.replace(/\,/g, '');
    while (value.length > 1 && value[0] == '0' && value[1] != '.') value = value.substring(1);
    if (value != '' && value != '0') {
        if (value[value.length - 1] != '.') {
            if (value.indexOf('.00') > 0) value = value.substring(0, value.length - 3);
            value = addCommas(value);
            return value;
        }
        else return value;
    }
    else return 0;
}

function addCommas(nStr) {
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function checkKeyCodeNumber(e){
    return !((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode == 8 ||  e.keyCode == 35 || e.keyCode == 36 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 46);
}

/* type = 1 - success
 other - error
 */
function showNotification(msg, type) {
    var typeText = 'error';
    if (type == 1 || type == 200) typeText = 'success';
    var notice = new PNotify({
        title: 'Thông báo',
        text: msg,
        type: typeText,
        delay: 2000,
        addclass: 'stack-bottomright',
        stack: {"dir1": "up", "dir2": "left", "firstpos1": 15, "firstpos2": 15}
    });
}


function redirect(reload, url) {
    if (reload) window.location.reload(true);
    else window.location.href = url;
}

function scrollTo(eleId) {
    $('html, body').animate({
        scrollTop: $(eleId).offset().top - 200
    }, 1000);
    $(eleId).focus();
}

//validate
function validateEmpty(container) {
    if(typeof(container) == 'undefined') container = 'body';
    var flag = true;
    $(container + ' .hmdrequired').each(function () {
        if ($(this).val().trim() == '') {
            showNotification($(this).attr('data-field') + ' không được bỏ trống', 0);
            $(this).focus();
            flag = false;
            return false;
        }
    });
    return flag;
}

function validateNumber(container, isInt, msg) {
    if(typeof(container) == 'undefined') container = 'body';
    if(typeof(msg) == 'undefined') msg = ' không được bé hơn 0';
    var flag = true;
    var value = 0;
    $(container + ' .hmdrequiredNumber').each(function () {
        value = replaceCost($(this).val(), isInt);
        if (value <= 0) {
            showNotification($(this).attr('data-field') + msg, 0);
            $(this).focus();
            flag = false;
            return false;
        }
    });
    return flag;
}

function checkEmptyEditor(text) {
    text = text.replace(/\&nbsp;/g, '').replace(/\<p>/g, '').replace(/\<\/p>/g, '').trim();
    return text.length > 0;
}

function makeSlug(str) {
    var slug = str.trim().toLowerCase();
    // change vietnam character
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    // remove special character
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    // change space to -
    slug = slug.replace(/ /gi, "-");
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    return slug;
}

function progressBarUpload(progressBarId) {
    var xhr = new window.XMLHttpRequest();
    xhr.upload.addEventListener("progress", function (evt) {
        if (evt.lengthComputable) {
            var percentComplete = evt.loaded / evt.total;
            percentComplete = parseInt(percentComplete * 100);
            var prb = progressBarId.find('.progress-bar');
            prb.text(percentComplete + '%');
            prb.css({
                width: percentComplete + '%'
            });
            if (percentComplete === 100) {
                setTimeout(function () {
                    prb.text('Tải ảnh lên hoàn thành');
                }, 1000);
            }
        }
    }, false);
    return xhr;
}

function validateImage(fileName) {
    var typeFile = getFileExtension(fileName);
    var whiteList = ['jpeg', 'jpg', 'png', 'bmp', 'svg'];
    if (whiteList.indexOf(typeFile) === -1) {
        showNotification('Tệp tin phải là ảnh có định dạng , jpeg/jpg/png/bmp/svg', 0);
        return false;
    }
    return true;
}

function getFileExtension(fileName) {
    return fileName.split(".").pop().toLowerCase();
}


//pagging
function pagging(pageId) {
    $('input#pageId').val(pageId);
    $('input#submit').trigger('click');
}

function chooseFile(inputFileImage, fileProgress, fileTypeId, fnSuccess) {
    inputFileImage.change(function (e) {
        var file = this.files[0];
        if(!validateImage(file.name)) return;
        var reader = new FileReader();
        reader.addEventListener("load", function () {
            fileProgress.show();
            $.ajax({
                xhr: function () {
                    return progressBarUpload(fileProgress);
                },
                type: 'POST',
                url: $('input#uploadFileUrl').val(),
                data: {
                    FileBase64: reader.result,
                    FileTypeId: fileTypeId
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if(json.code == 1) fnSuccess(json.data);
                    else showNotification(json.message, json.code);
                    fileProgress.hide();
                },
                error: function (response) {
                    fileProgress.hide();
                    showNotification($('input#errorCommonMessage').val(), 0);
                }
            });
        }, false);
        if (file) reader.readAsDataURL(file);
    });
}


function province(provinceIdStr, districtIdStr, wardIdStr) {
    if(typeof(provinceIdStr) == 'undefined'){
        provinceIdStr = 'province_id';
        districtIdStr = 'district_id';
        wardIdStr = 'ward_id';
    }
    var selPro = $('select#' + provinceIdStr);
    if (selPro.length > 0) {
        var selDistrict = $('select#' + districtIdStr);
        var selWard = $('select#' + wardIdStr);
        selDistrict.find('option').hide();
        selDistrict.find('option[value="0"]').show();
        var provinceId = selPro.val();
        if (provinceId != '0') selDistrict.find('option[data-id="' + provinceId + '"]').show();
        selPro.change(function () {
            selDistrict.find('option').hide();
            provinceId = $(this).val();
            if (provinceId != '0') selDistrict.find('option[data-id="' + provinceId + '"]').show();
            selDistrict.val('0');
            //selWard.val('0');
            selWard.html('<option value="0">--Chọn--</option>');
        });
        var districtId = selDistrict.val();
        console.log(districtId)
        if (districtId != '0') getListWard(districtId, selWard, selWard.attr('data-id'));
        selDistrict.change(function () {
            districtId = $(this).val();
            if (districtId != '0') getListWard(districtId, selWard, 0);
        });
    }
}

function getListWard(districtId, selWard, wardId){
    
    $.ajax({
        type: "POST",
        url: $('input#getListWardUrl').val(),
        data: {
            district_id: districtId
        },
        success: function (response) {
            var data = $.parseJSON(response);
            var html = '<option value="0">--Chọn--</option>';
            for(var i = 0; i < data.length; i++) html += '<option value="' + data[i].id + '">' + data[i].ward_name + '</option>';
            selWard.html(html).val(wardId);
        },
        error: function (response) {
            selWard.html('<option value="0">--Chọn--</option>');
        }
    });
}

function checkPhoneNumber(phone) {
    var flag = false;
    // var phone = $('input#phoneNumber').val().trim();
    phone = phone.replace('(+84)', '0');
    phone = phone.replace('+84', '0');
    phone = phone.replace('0084', '0');
    phone = phone.replace(/ /g, '');
    if (phone != '') {
        var firstNumber = phone.substring(0, 2);
        if ((firstNumber == '09' || firstNumber == '08' || firstNumber == '03') && phone.length == 10) {
            if (phone.match(/^\d{10}/)) {
                flag = true;
            }
        } else if (firstNumber == '01' && phone.length == 11) {
            if (phone.match(/^\d{11}/)) {
                flag = true;
            }
        }
    }
    return flag;
}

function randomPassword(length) {
    var chars = "abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890";
    var pass = "";
    for (var x = 0; x < length; x++) {
        var i = Math.floor(Math.random() * chars.length);
        pass += chars.charAt(i);
    }
    return pass;
}

function genDisplayOrder(id) {
    let html = `<select class="form-control" name="DisplayOrder_${id}" id="displayOrder_${id}" onchange="changeDisplayOrder(this, ${id})" data-id="${id}">`;
    for (let index = 1; index <= 200; index++) {
        let selected = '';
        if(index == id) selected = 'selected';
        html += `<option value="${index}" ${selected} >${index}</option>`;
    }
    html += '</select>';
    return html;
}

function formatPrice(price, currency = '') {
    if(!currency) return price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    if(currency == 'VND') return price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + ' ' + currency;
    if(currency == 'USD') return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(price);
}

function convertWeekday(date = '') {
    let weekDay = '';
    if(date) {
        let day = moment(new Date(date)).isoWeekday();
        switch (day) {
            case 1:
                weekDay = 'Thứ 2'
                break;
            case 2:
                weekDay = 'Thứ 3'
                break;
            case 3:
                weekDay = 'Thứ 4'
                break;
            case 4:
                weekDay = 'Thứ 5'
                break;
            case 5:
                weekDay = 'Thứ 6'
                break;
            case 6:
                weekDay = 'Thứ 7'
                break;
            case 7:
                weekDay = 'Chủ nhật'
                break;
            default:
                weekDay = '';
                break;
        }
    }
    return weekDay;
}

function validateEmail(email) {
    if(email) {
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
    return false;
}

function allEqual(input) {
    return input.split('').every(char => char === input[0]);
}

function validatePhone(phoneNumber, phoneCode) {
    if(phoneNumber, phoneCode) {
        let flag = true;
        if(phoneCode == '+84') {
            const vnfRegex = /(84|0[3|5|7|8|9])+([0-9]{8})\b/g;
            if(vnfRegex.test(phoneNumber) == false){
                flag = false;
            }
        } else if(phoneNumber.length > 15 || allEqual(phoneNumber)){
            flag = false;
        }
        return flag;
    }
    return false;
}