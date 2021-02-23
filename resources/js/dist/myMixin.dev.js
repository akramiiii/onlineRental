"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;
var _default = {
  methods: {
    check_mobile_number: function check_mobile_number() {
      if (isNaN(this.mobile)) {
        return true;
      } else {
        if (this.mobile.toString().trim().length == 11) {
          if (this.mobile.toString().charAt(0) == "0" && this.mobile.toString().charAt(1) == "9") {
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
    showModalBox: function showModalBox() {
      this.$refs.data.setTitle("افزودن آدرس جدید");
      $("#myModal").modal("show");
    },
    updateRow: function updateRow(address) {
      this.$refs.data.setUpdateData(address, "ویرایش آدرس");
    },
    remove_address: function remove_address(address) {
      this.remove_address_id = address.id;
      this.show_dialog_box = true;
    },
    delete_address: function delete_address(paginate) {
      var _this = this;

      var string = paginate == undefined ? "" : "?paginate=ok";
      $("#loading_box").show();
      this.show_dialog_box = false;
      var url = this.$siteUrl + "/user/removeAddress/" + this.remove_address_id + string;
      this.axios["delete"](url).then(function (response) {
        $("#loading_box").hide();

        if (response.data != "error") {
          _this.AddressLists = response.data;
        }
      })["catch"](function (error) {
        $("#loading_box").hide();
      });
    },
    updateAddressList: function updateAddressList(data) {
      this.AddressLists = data;
    }
  }
};
exports["default"] = _default;