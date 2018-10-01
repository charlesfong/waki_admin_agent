function capitalize(string) { //INDONESIA -> Indonesia
    return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//      METHOD - METHOD KHUSUS MEMBER
//
//function untuk mengambil data dari table MEMBER
var actionDelete = $("#actionDelete").prop('action');
var actionEdit = $("#actionEdit").prop('action');

function GetListMemberData(idx){
    var element_table = document.getElementsByName('collection');
    var element_tableRows = element_table[0].rows;
    var member_reg_date = element_tableRows[idx].cells[0].innerHTML;
    var member_kode = element_tableRows[idx].cells[1].innerHTML;
    var member_nama = element_tableRows[idx].cells[2].innerHTML;
    var member_address = element_tableRows[idx].cells[3].innerHTML;
    var member_province = element_tableRows[idx].cells[4].innerHTML;
    var member_district = element_tableRows[idx].cells[5].innerHTML;
    var member_country = element_tableRows[idx].cells[6].innerHTML;
    var member_branch = element_tableRows[idx].cells[7].innerHTML;
    var member_phone = element_tableRows[idx].cells[8].innerHTML;
    var member_email = element_tableRows[idx].cells[9].innerHTML;
    var member_age = element_tableRows[idx].cells[10].innerHTML;
    
    return {kode : member_kode, nama : member_nama, address : member_address, country : member_country, branch : member_branch, 
        phone : member_phone, email : member_email, reg_date : member_reg_date, province : member_province, district : member_district,
        age : member_age};
}

$("#change-password").click(function(e) {
        $("#modal-ChangePassword").modal("show");
});

//untuk menampilkan modal hapus data MEMBER dan menampilkan data mana yang mau di hapus
$(".btn-deleteMember").click(function(e) {
    var dataMember = GetListMemberData(this.name);
    document.getElementById("delete-member").innerHTML = "Do you want to delete "+ dataMember.kode +" - "+ dataMember.nama +"?";
    document.getElementById("btn-confirmDeleteMember").value = this.value;
    $("#actionDelete").prop('action', actionDelete+'/'+this.value);
    $("#modal-DeleteConfirm").modal("show");
});


//untuk menampilkan modal edit data MEMBER dan menampilkan data mana yg mau di edit
$(".btn-editMember").click(function(e) {
    var dataMember = GetListMemberData(this.name);
    document.getElementById("txtregdate-member").value = dataMember.reg_date;
    document.getElementById("txtkode-member").value = dataMember.kode;
    document.getElementById("txtnama-member").value = dataMember.nama;
    document.getElementById("txtaddress-member").value = dataMember.address;
    document.getElementById("txtcountry-member").value = dataMember.country;
    //document.getElementById("txtbranch-member").value = dataMember.branch;
    document.getElementById("txtprovince-member").value = dataMember.province;
    document.getElementById("txtphone-member").value = dataMember.phone;
    document.getElementById("txtemail-member").value = dataMember.email;
    document.getElementById("txtage-member").value = dataMember.age;
    document.getElementById("btn-confirmUpdateMember").value = 
    this.value;
    $("#actionEdit").prop('action', actionEdit+'/'+this.value);

    var pilihanProvinsi = dataMember.province;
    var isiOption = "";

    var $el = $("#txtdistrict-member");
    $el.empty();
    $.get( "etc/select-"+unescape(pilihanProvinsi)+".php", function( data ) {
      $el.append(data);
    });
    setTimeout(function(){
        document.getElementById("txtdistrict-member").value = dataMember.district;
    }, 300)
    //$("#txtdistrict-member").children("optgroup").eq(0).children("option:contains('"+dataMember.district+"')").attr("selected", "selected");
    //alert($("#txtdistrict-member").children("optgroup").eq(0).html());

    $("#modal-UpdateForm").modal("show");
});

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//      METHOD - METHOD KHUSUS USER
//
//function untuk mengambil data dari table USER
function GetListUserData(idx){
    var element_table = document.getElementsByName('collection');
    var element_tableRows = element_table[0].rows;
    var user_kode = element_tableRows[idx].cells[0].innerHTML;
    var user_nama = element_tableRows[idx].cells[1].innerHTML;
    var user_username = element_tableRows[idx].cells[2].innerHTML;
    var user_role = element_tableRows[idx].cells[3].innerHTML;
    var user_country = element_tableRows[idx].cells[4].innerHTML;
    var user_branch = element_tableRows[idx].cells[5].innerHTML;
    var user_permissions = element_tableRows[idx].cells[6].innerHTML;
    
    return {kode : user_kode, nama : user_nama, username : user_username, role : user_role, country : user_country, 
        branch : user_branch, permissions : user_permissions};
}

//untuk menampilkan modal hapus data USER dan menampilkan data mana yang mau di hapus
$(".btn-deleteUser").click(function(e) {
        var dataUser = GetListUserData(this.name);
        document.getElementById("txt-delete-user").innerHTML = "Do you want to delete "+ dataUser.kode +" - "+ dataUser.nama +"?";
        document.getElementById("btn-confirmDeleteUser").value = this.value;
        $("#actionDelete").prop('action', actionDelete+'/'+this.value);
        $("#modal-DeleteConfirm").modal("show");
});

//untuk menampilkan modal edit data USER dan menampilkan data mana yg mau di edit
$(".btn-editUser").click(function(e) {
    //ResetBranch();
    ResetPermission();
    ResetError();

    var dataUser = GetListUserData(this.name);
    document.getElementById("txtkode-user").value = dataUser.kode;
    document.getElementById("txtnama-user").value = dataUser.nama;
    document.getElementById("txtusername-user").value = dataUser.username;
    document.getElementById("txtcountry-user").value = dataUser.country;
    document.getElementById("txtbranch-user").value = dataUser.branch;
    document.getElementById("btn-confirmUpdateUser").value = this.value;
    $("#actionEdit").prop('action', actionEdit+'/'+this.value);

    var permissions = JSON.parse(dataUser.permissions, true);
    for(let item in permissions)
    {
        $("#"+item).prop('name', "permissions["+item+"]");
        $("#"+item).prop('checked', permissions[item]);

        //MPC
        if(item == "browse-mpc" && permissions[item] == true)
        {
            $("#check-DeleteMPC").addClass("d-inline-block");
            $("#check-EditMPC").addClass("d-inline-block");
        }

        else if(item == "all-branch-mpc" && permissions[item] == true)
        {
            $("#check-AllCountryMPC").addClass("d-inline-block");
        }

        //DATA UNDANGAN
        else if(item == "browse-data-undangan" && permissions[item] == true)
        {
            $("#check-DeleteDataUndangan").addClass("d-inline-block");
            $("#check-EditDataUndangan").addClass("d-inline-block");
        }

        else if(item == "all-branch-data-undangan" && permissions[item] == true)
        {
            $("#check-AllCountryDataUndangan").addClass("d-inline-block");
        }

        //DATA OUTSITE
        else if(item == "browse-data-outsite" && permissions[item] == true)
        {
            $("#check-DeleteDataOutsite").addClass("d-inline-block");
            $("#check-EditDataOutsite").addClass("d-inline-block");
        }

        else if(item == "all-branch-data-outsite" && permissions[item] == true)
        {
            $("#check-AllCountryDataOutsite").addClass("d-inline-block");
        }

        //DATA THERAPY
        else if(item == "browse-data-therapy" && permissions[item] == true)
        {
            $("#check-DeleteDataTherapy").addClass("d-inline-block");
            $("#check-EditDataTherapy").addClass("d-inline-block");
        }

        else if(item == "all-branch-data-therapy" && permissions[item] == true)
        {
            $("#check-AllCountryDataTherapy").addClass("d-inline-block");
        }

        //TYPE CUST
        else if(item == "browse-type-cust" && permissions[item] == true)
        {
            $("#check-DeleteTypeCust").addClass("d-inline-block");
            $("#check-EditTypeCust").addClass("d-inline-block");
        }

        //CSO
        else if(item == "browse-cso" && permissions[item] == true)
        {
            $("#check-DeleteCSO").addClass("d-inline-block");
            $("#check-EditCSO").addClass("d-inline-block");
        }

        else if(item == "all-branch-cso" && permissions[item] == true)
        {
            $("#check-AllCountryCSO").addClass("d-inline-block");
        }

        //BRANCH
        else if(item == "browse-branch" && permissions[item] == true)
        {
            $("#check-DeleteBranch").addClass("d-inline-block");
            $("#check-EditBranch").addClass("d-inline-block");
        }

        //USER
        else if(item == "browse-user" && permissions[item] == true)
        {
            $("#check-DeleteUser").addClass("d-inline-block");
            $("#check-EditUser").addClass("d-inline-block");
        }

        else if(item == "all-branch-user" && permissions[item] == true)
        {
            $("#check-AllCountryUser").addClass("d-inline-block");
        }
    }

    $("#modal-UpdateForm").modal("show");
});

//Untuk reset Error ketika close modal
function ResetError()
{
    $("#txtnama-user").removeClass("is-invalid");
    $("#txtusername-user").removeClass("is-invalid");
    $("#txtcountry-user").removeClass("is-invalid");
    $("#txtbranch-user").removeClass("is-invalid");
}

//Untuk reset permissions ketika close modal
function ResetPermission()
{
    //MPC
    $("#check-EditMPC").removeClass("d-inline-block");
    $("#check-DeleteMPC").removeClass("d-inline-block");

    $("#check-AllCountryMPC").removeClass("d-inline-block");

    //DATA UNDANGAN
    $("#check-EditDataUndangan").removeClass("d-inline-block");
    $("#check-DeleteDataUndangan").removeClass("d-inline-block");

    $("#check-AllCountryDataUndangan").removeClass("d-inline-block");

    //DATA OUTSITE
    $("#check-EditDataOutsite").removeClass("d-inline-block");
    $("#check-DeleteDataOutsite").removeClass("d-inline-block");

    $("#check-AllCountryDataOutsite").removeClass("d-inline-block");

    //DATA THERAPY
    $("#check-EditDataTherapy").removeClass("d-inline-block");
    $("#check-DeleteDataTherapy").removeClass("d-inline-block");

    $("#check-AllCountryDataTherapy").removeClass("d-inline-block");

    //TYPE CUST
    $("#check-EditTypeCust").removeClass("d-inline-block");
    $("#check-DeleteTypeCust").removeClass("d-inline-block");

    //CSO
    $("#check-EditCSO").removeClass("d-inline-block");
    $("#check-DeleteCSO").removeClass("d-inline-block");

    $("#check-AllCountryCSO").removeClass("d-inline-block");

    //BRANCH
    $("#check-EditBranch").removeClass("d-inline-block");
    $("#check-DeleteBranch").removeClass("d-inline-block");

    //USER
    $("#check-DeleteUser").removeClass("d-inline-block");
    $("#check-EditUser").removeClass("d-inline-block");

    $("#check-AllCountryUser").removeClass("d-inline-block");
}

//method berbeda jangan di rubah
//function" di bawah ini berguna untuk khusus user role
//Jika Browse di-check, maka Edit dan Delete akan muncul, berlaku sebaliknya
//Jika AllBranch di-check, maka AllCountry akan muncul, berlaku sebaliknya
//MPC
$("#group-mpc .div-CheckboxGroup #browse-mpc").click(function(e) {
        $("#check-DeleteMPC").toggleClass("d-inline-block");
        $("#check-EditMPC").toggleClass("d-inline-block");
        $("#edit-mpc").prop('checked', false);
        $("#delete-mpc").prop('checked', false);
});
$("#group-mpc .div-CheckboxGroup #all-branch-mpc").click(function(e) {
        $("#check-AllCountryMPC").toggleClass("d-inline-block");
        $("#all-country-mpc").prop('checked', false);
});

//DATA UNDANGAN
$("#group-data-undangan .div-CheckboxGroup #browse-data-undangan").click(function(e) {
        $("#check-DeleteDataUndangan").toggleClass("d-inline-block");
        $("#check-EditDataUndangan").toggleClass("d-inline-block");
        $("#edit-data-undangan").prop('checked', false);
        $("#delete-data-undangan").prop('checked', false);
});
$("#group-data-undangan .div-CheckboxGroup #all-branch-data-undangan").click(function(e) {
        $("#check-AllCountryDataUndangan").toggleClass("d-inline-block");
        $("#all-country-data-undangan").prop('checked', false);
});

//DATA OUTSITE
$("#group-data-outsite .div-CheckboxGroup #browse-data-outsite").click(function(e) {
        $("#check-DeleteDataOutsite").toggleClass("d-inline-block");
        $("#check-EditDataOutsite").toggleClass("d-inline-block");
        $("#edit-data-outsite").prop('checked', false);
        $("#delete-data-outsite").prop('checked', false);
});
$("#group-data-outsite .div-CheckboxGroup #all-branch-data-outsite").click(function(e) {
        $("#check-AllCountryDataOutsite").toggleClass("d-inline-block");
        $("#all-country-data-outsite").prop('checked', false);
});

//DATA THERAPY
$("#group-data-therapy .div-CheckboxGroup #browse-data-therapy").click(function(e) {
        $("#check-DeleteDataTherapy").toggleClass("d-inline-block");
        $("#check-EditDataTherapy").toggleClass("d-inline-block");
        $("#edit-data-therapy").prop('checked', false);
        $("#delete-data-therapy").prop('checked', false);
});
$("#group-data-therapy .div-CheckboxGroup #all-branch-data-therapy").click(function(e) {
        $("#check-AllCountryDataTherapy").toggleClass("d-inline-block");
        $("#all-country-data-therapy").prop('checked', false);
});

//TYPE CUST
$("#group-type-cust .div-CheckboxGroup #browse-type-cust").click(function(e) {
        $("#check-DeleteTypeCust").toggleClass("d-inline-block");
        $("#check-EditTypeCust").toggleClass("d-inline-block");
        $("#edit-type-cust").prop('checked', false);
        $("#delete-type-cust").prop('checked', false);
});

//CSO
$("#group-cso .div-CheckboxGroup #browse-cso").click(function(e) {
        $("#check-DeleteCSO").toggleClass("d-inline-block");
        $("#check-EditCSO").toggleClass("d-inline-block");
        $("#edit-cso").prop('checked', false);
        $("#delete-cso").prop('checked', false);
});
$("#group-cso .div-CheckboxGroup #all-branch-cso").click(function(e) {
        $("#check-AllCountryCSO").toggleClass("d-inline-block");
        $("#all-country-cso").prop('checked', false);
});

//BRANCH
$("#group-branch .div-CheckboxGroup #browse-branch").click(function(e) {
        $("#check-DeleteBranch").toggleClass("d-inline-block");
        $("#check-EditBranch").toggleClass("d-inline-block");
        $("#edit-branch").prop('checked', false);
        $("#delete-branch").prop('checked', false);
});

//USER
$("#group-user .div-CheckboxGroup #browse-user").click(function(e) {
        $("#check-DeleteUser").toggleClass("d-inline-block");
        $("#check-EditUser").toggleClass("d-inline-block");
        $("#edit-user").prop('checked', false);
        $("#delete-user").prop('checked', false);
});
$("#group-user .div-CheckboxGroup #all-branch-user").click(function(e) {
        $("#check-AllCountryUser").toggleClass("d-inline-block");
        $("#all-country-user").prop('checked', false);
});


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//      METHOD - METHOD KHUSUS BRANCH
//
//function untuk mengambil data dari table BRANCH
function GetListBranchData(idx){
    var element_table = document.getElementsByName('collection');
    var element_tableRows = element_table[0].rows;
    var branch_kode = element_tableRows[idx].cells[0].innerHTML;
    var branch_nama = element_tableRows[idx].cells[1].innerHTML;
    var branch_country = element_tableRows[idx].cells[2].innerHTML;
    
    return {kode : branch_kode, nama : branch_nama, country : branch_country};
}

//untuk menampilkan modal hapus data BRANCH dan menampilkan data mana yang mau di hapus
$(".btn-deleteBranch").click(function(e) {
    var dataBranch = GetListBranchData(this.name);
    document.getElementById("delete-branch").innerHTML = "Do you want to delete "+ dataBranch.kode +" - "+ dataBranch.nama +"?";
    document.getElementById("btn-confirmDeleteBranch").value = this.value;
    $("#actionDelete").prop('action', actionDelete+'/'+this.value);
    $("#modal-DeleteConfirm").modal("show");
});

//untuk menampilkan modal edit data BRANCH dan menampilkan data mana yg mau di edit
$(".btn-editBranch").click(function(e) {
    var dataBranch = GetListBranchData(this.name);
    document.getElementById("txtkode-branch").value = dataBranch.kode;
    document.getElementById("txtnama-branch").value = dataBranch.nama;
    document.getElementById("txtcountry-branch").value = dataBranch.country;
    document.getElementById("btn-confirmUpdateBranch").value = 
    this.value;
    $("#actionEdit").prop('action', actionEdit+'/'+this.value);
    $("#modal-UpdateForm").modal("show");
});

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(window.matchMedia("(max-width: 768px)").matches){
    $(".pagination-wrapper").addClass("pagination-sm");
}

if(window.matchMedia("(min-width: 768px)").matches){
    $(".pagination-wrapper").removeClass("pagination-sm");
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//      METHOD KHUSUS COMBOBOX OFFLINE KOTA
//
//function untuk mengambil data dari file php masuk ke option setelah di pilihnya option provinsi
$("#province").change( function (){
    var pilihanProvinsi = this.value;
    var isiOption = "";

    var $el = $("#district");
    $el.empty();
    $.get( "etc/select-"+unescape(pilihanProvinsi)+".php", function( data ) {
      $el.append(data);
    });
});

$("#txtprovince-member").change( function (){
    var pilihanProvinsi = this.value;
    var isiOption = "";

    var $el = $("#txtdistrict-member");
    $el.empty();
    $.get( "etc/select-"+unescape(pilihanProvinsi)+".php", function( data ) {
      $el.append(data);
    });
});

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//      METHOD - METHOD KHUSUS PRINT REPORT
//
//function untuk passing kan value btn apa yang diklik

$("#btn-global, #btn-detail, #btn-umur").click(function(e){
    e.preventDefault();
    $("#modal-PrintReport").modal("show");
    if($(this).attr("value") == "2") //Umur
    {
        $(".ageGroup").css("display", "block");
    }
    else
    {
        $(".ageGroup").css("display", "none");
    }
    $("#btn-print").val($(this).attr("value"));
});