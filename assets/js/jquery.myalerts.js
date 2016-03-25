function Myalert(title, content) {
	this.buttonok = 'アップグレード';
	this.buttonc = 'ＯＫ';
	this.title = title;
	this.content = content;
	//	return this;
}
Myalert.prototype.setOkButton = function(buttonok) {
	this.buttonok = buttonok;
};
Myalert.prototype.setCButton = function(buttonc) {
	this.buttonc = buttonc;
};
Myalert.prototype.alert = function(callback) {
	this.createAlertModal(0);
	$("#myAlertModal").modal('show');
	if (typeof callback == "function") {
		var obj = $(".btn-alert-cancel");
		callback(obj);
	} else  {}
};
Myalert.prototype.createAlertModal = function(type) {
	var bodystr = "<div id='baseModalDiv'></div>";
	$('body').append(bodystr);
	var str = '<div class="modal fade" id="myAlertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">';
	str += '<div class="modal-dialog" role="document"><div class="modal-content">';
	str += '<div class="modal-header bg-red top-left top-right">';
	str += '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
	str += '<h4 class="color-white modal-title" id="myModalLabel">' + this.title + '</h4>';
	str += "</div>";
	str += '<div class="modal-body">' + this.content + "</div>";
	str += '<div class="modal-footer">';
	str += '<button type="button" class="btn btn-default btn-alert-cancel" data-dismiss="modal">' + this.buttonc + '</button>';
	if (typeof type != "undefined" && type != 0) {
		str += '<button type="button" class="btn btn-primary bg-red btn-alert-ok">' + this.buttonok + '</button>';
	}
	str += '</div></div></div></div>';
	$('#baseModalDiv').html(str);
};

// $("#myAlertModal").modal('hide');
Myalert.prototype.hide = function () {
    $("#myAlertModal").modal('hide');
};

Myalert.prototype.Myconfirm = function(callback) {
	this.createAlertModal(1);
	$("#myAlertModal").modal('show');
	if (typeof callback == "function") {
		var returns = {};
		returns.ok=$(".btn-alert-ok");
		returns.cancel=$(".btn-alert-cancel");
		callback(returns);
	}
};