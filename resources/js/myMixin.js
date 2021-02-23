export default {
    methods: {
        check_mobile_number() {
            if (isNaN(this.mobile)) {
                return true;
            } else {
                if (this.mobile.toString().trim().length == 11) {
                    if (
                        this.mobile.toString().charAt(0) == "0" &&
                        this.mobile.toString().charAt(1) == "9"
                    ) {
                        return false;
                    } else {
                        return true;
                    }
                } else if (this.mobile.toString().trim().length == 10) {
                    if (this.mobile.toString().charAt(0) == "9") {
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    return true;
                }
            }
        },
        showModalBox: function() {
            this.$refs.data.setTitle("افزودن آدرس جدید");
            $("#myModal").modal("show");
        },
        updateRow: function(address) {
            this.$refs.data.setUpdateData(address, "ویرایش آدرس");
        },
        remove_address: function(address) {
            this.remove_address_id = address.id;
            this.show_dialog_box = true;
        },
        delete_address: function(paginate) {
            const string = paginate == undefined ? "" : "?paginate=ok";
            $("#loading_box").show();
            this.show_dialog_box = false;
            const url =
                this.$siteUrl +
                "/user/removeAddress/" +
                this.remove_address_id +
                string;
            this.axios
                .delete(url)
                .then(response => {
                    $("#loading_box").hide();
                    if (response.data != "error") {
                        this.AddressLists = response.data;
                    }
                })
                .catch(error => {
                    $("#loading_box").hide();
                });
        },
        updateAddressList: function(data) {
            this.AddressLists = data;
        }
    }
};