(function( $ ) {
	'use strict';
})( jQuery );

function handlekeys() {
	return {
		'ajaxURL': ajax.url,
		'changevalue': '',
		'hidemail': false,
		'showpopup': false,
		'loader': false,
		'btntext': "Add Key",
		'selected_category': '',
		'locations': [
						{
							'value':'customer',
							'text':'Customer',
						},
						{
							 'value':'employee', 
							 'text':'Employee',
						},
						{
							 'value':'office', 
							 'text':'At office',
						}
					],
		'employees': [],
		'customers': [],
		'keys': [],
		'getDate': '',
		'keytoupdate': '',
		'addkey': {
			'id': '',
			'title': '',
			'color': '',
			'action': 'addkey',
		},
		'addKeyForm': {
			'error': false,
			'errortext': '',
			'type': 'primary',
		},
		async locationSelected(id) {
				this.keys = this.keys.map(key => {
						 let temp = Object.assign({}, key);
						 if(key.id == id) {
							if (key.location == 'employee')
									temp.customer = ''; 
							else if(key.location == 'customer')
								temp.employee = '';
							else if(key.location == 'office'){
								temp.employee = '';
								temp.customer = '';
							}
							temp.action = 'key_update';
							this.keytoupdate = temp;
						 }	
						 return temp;
				})
				this.updateKey();
		},
		async getmyKeys() {
			this.getKeys('byuser');
		},
		async getKeys(id='') {
			this.hidemail = false;
			await fetch(this.ajaxURL+"?action=get_keys&byuser="+id, {
				method: "GET",				
				headers: { 
						"Content-type": "application/json; charset=utf-8",
				} ,
				credentials: 'same-origin',
			}).then(res => res.json())
				.then(data => {
					this.keys = data.data;
					this.getcustomer_emps();
					//console.log(this.customers);
					this.loader=false;
				});
		},

		async getcustomer_emps() {
			await fetch(this.ajaxURL+"?action=getcustomer_emp", {
				method: "GET",				
				headers: { 
						"Content-type": "application/json; charset=utf-8",
				} ,
				credentials: 'same-origin',
			}).then(res => res.json())
				.then(data => {
					this.customers = data.customers;
					this.employees = data.employees;

					//console.log(this.customers);
					this.loader=false;
				});
		},

		async pendingKeys() {
			//this.changevalue = 'pending';
			this.getKeys("pending");
			this.hidemail = true;
		},

		async delete_key(id) {
			if (!id) {
				return false;
			}
			if(confirm('Are your sure you want to delete?')) {
				await fetch(this.ajaxURL+"?action=delete_key&key_id="+id, {
				method: "GET",				
				headers: { 
						"Content-type": "application/json; charset=utf-8",
				} ,
				credentials: 'same-origin',
				}).then(res => res.json())
				.then(data => {
					//console.log(this.customers);
					this.getKeys();
					this.loader=false;
				});
			}
			
			
		},

		async sendmail(id) {
			if (!id) {
				return false;
			}
			await fetch(this.ajaxURL+"?action=send_cus_mail&user_id="+id, {
				method: "GET",				
				headers: { 
						"Content-type": "application/json; charset=utf-8",
				} ,
				credentials: 'same-origin',
			}).then(res => res.json())
				.then(data => {
					//console.log(this.customers);
					this.loader=false;
				});
		},

		async updateKey() {
			this.makeFetch(this.keytoupdate).then(data => {
				this.getcustomer_emps();
			});
		},
		editKey(id) {
			this.keys.map(key => {
				if(key.id == id) {
					this.showPopup();
					this.btntext="Edit Key";
					this.addkey.id = key.id;
					this.addkey.title = key.title;
					this.addkey.color = key.key_color;
				}
				return key;
			})	
		},
		showPopup() {
			this.addkey.id = '';
			this.addkey.title = '';
			this.addkey.color = '';
			this.btntext="Add Key";
			this.showpopup = true;
		},
		async addKeyFunc() {
			this.addKeyForm.error = false;
				if(this.addkey.title == '' || this.addkey.color == '') {
					this.addKeyForm.error = true;
					this.addKeyForm.errortext = "Kindly enter title and color";
				} else {
					await this.makeFetch(this.addkey).then(data => {
						this.getKeys();
						this.showpopup = false;
					});
				}
		},
		makeFetch(data) {
			var params = new URLSearchParams();
			//very simply, doesn't handle complete objects
			for(var i in data){
				params.append(i,data[i]);
			}
			return fetch(this.ajaxURL, {
				method: 'POST', // *GET, POST, PUT, DELETE, etc.
				mode: 'cors', // no-cors, *cors, same-origin
				cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
				credentials: 'same-origin', // include, *same-origin, omit
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
					// 'Content-Type': 'application/x-www-form-urlencoded',
				},
				redirect: 'follow', // manual, *follow, error
				referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
				body: params // body data type must match "Content-Type" header
			})// captura o erro 
			// converte o sucesso em JSON
			.then(response => response.json())
			.catch((error) => {
				console.log(error)
			});
		}	
	}
}
