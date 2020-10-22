<div x-data="handlekeys()" x-init="getKeys()">
  <h2 class="title is-2 centerkeys"><?php echo __("Keys", $this->plugin_name)?></h2>
  <div class="up_heaidng">
    <a class="button" @click="getKeys()"><?php echo __("All Keys", $this->plugin_name)?></a> 
    <a class="button" @click="getmyKeys()"><?php echo __("My Keys", $this->plugin_name)?></a> 
    <a class="button" @click="pendingKeys()"><?php echo __("Pending", $this->plugin_name)?></a> 
    <a class="button" @click="showPopup()"><?php echo __("Add New", $this->plugin_name)?></a>
  </div>
  <table class="pure-table pure-table-bordered" style="background-color: white; width: 98%;">
        <tr class="pure_th">
          <th></th>
          <th><?php echo __("Title", $this->plugin_name)?></th>
          <th><?php echo __("Key Color", $this->plugin_name)?></th>
          <th><?php echo __("Location", $this->plugin_name)?></th>
          <th><?php echo __("Employee", $this->plugin_name)?></th>
          <th><?php echo __("Customer", $this->plugin_name)?></th>
          <th class="hidemail" x-show="hidemail"><?php echo __("Mail", $this->plugin_name)?></th>
          <th class="hidemail" x-show="hidemail">
            <?php echo __("Last Reminder", $this->plugin_name)?>
            </th>
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
                  <option :selected="(key.employee == employee.id) ? true : false" :value="employee.id" x-text="employee.name" ></option>
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
              <a class="button" :disabled="(key.location == 'employee' || key.location == 'office') ? true : false" href="#sendmail" @click="sendmail(key.customer,key.id)"><?php echo __("Send", $this->plugin_name)?></a>
            </td>
            <td class="hidemail" x-show="hidemail" x-text="(key.reminder_date == '0000-00-00') ? '<?php echo __("Reminder not sent", $this->plugin_name)?>' : key.reminder_date "></td>
        </tr>
      </template>
      </table>
      <div id="popup1" class="pure-overlay" x-show="showpopup">
        <div class="pure-popup">
          <h2><?php echo __("Add New Key", $this->plugin_name)?></h2>
          <a class="close cursor-pointer" @click="showpopup = false">&times;</a>
          <div class="content">
            <div class="pure-alert pure-alert-danger" x-show="addKeyForm.error" x-text="addKeyForm.errortext"></div>
            <form class="pure-form pure-form-aligned">
              <fieldset>
                  <div class="pure-control-group">
                      <label for="aligned-name"><?php echo __("Title:", $this->plugin_name)?></label>
                      <input type="text" id="aligned-name" placeholder="<?php echo __("Enter Key Title:", $this->plugin_name)?>" x-model="addkey.title" />
                      <span class="pure-form-message-inline"><?php echo __("This is a required field.", $this->plugin_name)?></span>
                  </div>
                  <div class="pure-control-group">
                      <label for="aligned-password"><?php echo __("Color", $this->plugin_name)?></label>
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