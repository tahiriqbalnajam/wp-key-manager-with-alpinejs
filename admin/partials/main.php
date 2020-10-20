<div x-data="handlekeys()" x-init="getKeys()">
  <h2 class="title is-2 centerkeys">Keys</h2>
  <div class="up_heaidng">
    <a class="button" @click="getKeys()">All Keys</a> 
    <a class="button" @click="getmyKeys()">My Keys</a> 
    <a class="button" @click="pendingKeys()">Pending</a> 
    <a class="button" @click="showPopup()">Add New</a>
  </div>
  <table class="pure-table pure-table-bordered" style="background-color: white; width: 98%;">
        <tr class="pure_th">
          <th></th>
          <th>Title</th>
          <th>Key Color</th>
          <th>Location</th>
          <th>Employee</th>
          <th>Customer</th>
          <th class="hidemail" x-show="hidemail">Mail</th>
          <th class="hidemail" x-show="hidemail">Last Reminder</th>
        </tr>
      <template x-for="key in keys" :key="key.id">
        <tr>
            <td class="cancel_del" @click="delete_key(key.id)">&#10008;</td>
            <td x-text="key.title" @click="editKey(key.id)" class="cursor-pointer"></td>
            <td x-bind:class="key.key_color">
              <span :style="`background-color: ${key.key_color}`" class="circle_color"></span>
            </td>
            <td>
              <select x-model="key.location" @change="locationSelected(key.id)">
                <template x-for="location in locations" :key="location.value">
                  <option :selected="(key.location == location.value) ? true : false" :value="location.value" x-text="location.text" ></option>
                </template>
              </select>
            </td>
            <td>
              <select x-model="key.employee" :disabled="(key.location == 'customer' || key.location == 'office') ? true : false" @change="locationSelected(key.id)">
                 <option >---</option>
                <template x-for="employee in employees" :key="employee.name">
                  <option :selected="(key.employee == employee.name) ? true : false" :value="employee.name" x-text="employee.name" ></option>
                </template>
              </select>
            </td>
            <td>
              <select x-model="key.customer" :disabled="(key.location == 'employee' || key.location == 'office') ? true : false" @change="locationSelected(key.id)">
                 <option >---</option>
                <template x-for="customer in customers" :key="customer.name">
                  <option :selected="(key.customer == customer.id) ? true : false" :value="customer.id" x-text="customer.name" ></option>
                </template>
              </select>
            </td>
            <td class="hidemail" x-show="hidemail">
              <a class="button" :disabled="(key.location == 'employee' || key.location == 'office') ? true : false" href="#sendmail" @click="sendmail(key.customer,key.id)">Send</a>
            </td>
            <td class="hidemail" x-show="hidemail" x-text="key.reminder_date"></td>
        </tr>
      </template>
      </table>
      <div id="popup1" class="pure-overlay" x-show="showpopup">
        <div class="pure-popup">
          <h2>Add New Key</h2>
          <a class="close cursor-pointer" @click="showpopup = false">&times;</a>
          <div class="content">
            <div class="pure-alert pure-alert-danger" x-show="addKeyForm.error" x-text="addKeyForm.errortext"></div>
            <form class="pure-form pure-form-aligned">
              <fieldset>
                  <div class="pure-control-group">
                      <label for="aligned-name">Title:</label>
                      <input type="text" id="aligned-name" placeholder="Enter Key Title" x-model="addkey.title" />
                      <span class="pure-form-message-inline">This is a required field.</span>
                  </div>
                  <div class="pure-control-group">
                      <label for="aligned-password">Color</label>
                      <input id="aligned-password" data-jscolor="" x-model="addkey.color" :value="`${addkey.color}`"/>
                      <!-- <input type="text" id="aligned-password" placeholder="Enter color" x-model="addkey.color" /> -->
                  </div>
                  <div class="pure-controls">
                      <button type="button" class="pure-button pure-button-primary" @click="addKeyFunc()" x-text="btntext"></button>
                  </div>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
</div>