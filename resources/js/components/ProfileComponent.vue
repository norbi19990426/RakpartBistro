<template>
    <div>
        <a class="nav-link" @click.prevent="show()">
            Profil
        </a>
        <modal name="user-profile" height="auto">
            <div class="modal-container">
                <div class="col-1 profileMenu">
                    <a class="profileButtonPosition" @click="profile()">
                        <img src="/logo/user.png" class="profileButton">
                    </a>
                    <a class="profileButtonPosition" @click="profileEdit()">
                        <img src="/logo/edit.png" class="profileButton">
                    </a>
                </div>
                <!-- PROFIL ADATOK KIÍRATÁSA -->
                <div class="modal-body">
                    <div class="col-11" v-if="profileHide == true">
                        <div v-if="userProfile == null">
                            <h1>Még nincs profilja</h1>
                        </div>
                        <div class="profileDataContainer" v-else>
                            <h2 class="userName">{{form.vezeteknev}} {{form.keresztnev}}</h2>
                            <div class="profileData"><h4>Irányítószám:</h4>{{form.iranyitoszam}}</div>
                            <div class="profileData"><h4>Város:</h4>{{form.varos}}</div>
                            <div class="profileData"><h4>Lakcím:</h4>{{form.address}} {{form.emelet}}</div>
                            <div class="profileData"><h4>Email:</h4>{{form.email}}</div>
                            <div class="profileData"><h4>Telefonszám:</h4>{{form.telefonszam}}</div>
                        </div>
                    </div>
                <!-- PROFIL ADATOK SZERKEZTÉSE -->
                    <div class="col-11" v-else-if="userProfile != null">
                        <form method="POST" enctype="multipart/form-data" @submit.prevent="submitProfileUpdate">
                            <div class="form-group">
                                <label for="vezeteknev">Vezetéknév:</label>
                                <input type="text" v-model="form.vezeteknev" class="form-control"
                                :class="{'is-invalid' : form.errors.has('vezeteknev')}"
                                @keydown="form.errors.clear('vezeteknev')">
                                <div class="invalid-feedback" v-show="form.errors.has('vezeteknev')" v-text="form.errors.get('vezeteknev')"></div>
                            </div>
                            <div class="form-group">
                                <label for="keresztnev">Keresztnév:</label>
                                <input type="text"
                                v-model="form.keresztnev" class="form-control"
                                :class="{'is-invalid' : form.errors.has('keresztnev')}"
                                @keydown="form.errors.clear('keresztnev')">
                                <div class="invalid-feedback" v-show="form.errors.has('keresztnev')" v-text="form.errors.get('keresztnev')"></div>
                            </div>
                            <div class="form-gorup">
                                <label for="iranyitoszam">Irányítószám:</label>
                                <input type="number"
                                v-model="form.iranyitoszam" class="form-control"
                                :class="{'is-invalid' : form.errors.has('iranyitoszam')}"
                                @keydown="form.errors.clear('iranyitoszam')">
                                <div class="invalid-feedback" v-show="form.errors.has('iranyitoszam')" v-text="form.errors.get('iranyitoszam')"></div>
                            </div>
                            <div class="form-group">
                            <label for="varos">Város:</label>
                                <input type="text"
                                v-model="form.varos" class="form-control"
                                :class="{'is-invalid' : form.errors.has('varos')}"
                                @keydown="form.errors.clear('varos')">
                                <div class="invalid-feedback" v-show="form.errors.has('varos')" v-text="form.errors.get('varos')"></div>
                            </div>
                            <div class="form-group">
                                <label for="address">Utca, házszám:</label>
                                <input type="text" placeholder="Utcanév, házszám"
                                v-model="form.address" class="form-control"
                                :class="{'is-invalid' : form.errors.has('address')}"
                                @keydown="form.errors.clear('address')">
                                <div class="invalid-feedback" v-show="form.errors.has('address')" v-text="form.errors.get('address')"></div>
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Lépcsőház, emelet, ajtó, stb. (nem kötelező)"
                                v-model="form.emelet" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="telefonszam">Telefonszám:</label>
                                <input type="number" placeholder="Pl.: 0630 123 4567" v-model="form.telefonszam"
                                class="form-control"
                                :class="{'is-invalid' : form.errors.has('telefonszam')}"
                                @keydown="form.errors.clear('telefonszam')">
                                <div class="invalid-feedback" v-show="form.errors.has('telefonszam')" v-text="form.errors.get('telefonszam')"></div>
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail cím:</label>
                                <input type="email" v-model="form.email"
                                class="form-control"
                                :class="{'is-invalid' : form.errors.has('email')}"
                                    @keydown="form.errors.clear('email')">
                                    <div class="invalid-feedback" v-show="form.errors.has('email')" v-text="form.errors.get('email')"></div>
                            </div>
                            <div class="justify-content-between">
                                <button type="submit" class="profileSubmitButton">Profil szerkeztése</button>
                            </div>
                        </form>
                    </div>
                <!-- HA NINCS PROFIL AKKOR EZ JELENIK MEG PROFIL LÉTREHOZÁSÁHOZ -->
                    <div class="col-11" v-else-if="userProfile == null">
                        <form method="POST" enctype="multipart/form-data" @submit.prevent="submitProfileCreate">
                            <div class="form-group">
                                <label for="vezeteknev">Vezetéknév:</label>
                                <input type="text" v-model="form.vezeteknev" class="form-control"
                                :class="{'is-invalid' : form.errors.has('vezeteknev')}"
                                @keydown="form.errors.clear('vezeteknev')">
                                <div class="invalid-feedback" v-show="form.errors.has('vezeteknev')" v-text="form.errors.get('vezeteknev')"></div>
                            </div>
                            <div class="form-group">
                                <label for="keresztnev">Keresztnév:</label>
                                <input type="text"
                                v-model="form.keresztnev" class="form-control"
                                :class="{'is-invalid' : form.errors.has('keresztnev')}"
                                @keydown="form.errors.clear('keresztnev')">
                                <div class="invalid-feedback" v-show="form.errors.has('keresztnev')" v-text="form.errors.get('keresztnev')"></div>
                            </div>
                            <div class="form-gorup">
                                <label for="iranyitoszam">Irányítószám:</label>
                                <input type="number"
                                v-model="form.iranyitoszam" class="form-control"
                                :class="{'is-invalid' : form.errors.has('iranyitoszam')}"
                                @keydown="form.errors.clear('iranyitoszam')">
                                <div class="invalid-feedback" v-show="form.errors.has('iranyitoszam')" v-text="form.errors.get('iranyitoszam')"></div>
                            </div>
                            <div class="form-group">
                            <label for="varos">Város:</label>
                                <input type="text"
                                v-model="form.varos" class="form-control"
                                :class="{'is-invalid' : form.errors.has('varos')}"
                                @keydown="form.errors.clear('varos')">
                                <div class="invalid-feedback" v-show="form.errors.has('varos')" v-text="form.errors.get('varos')"></div>
                            </div>
                            <div class="form-group">
                                <label for="address">Utca, házszám:</label>
                                <input type="text" placeholder="Utcanév, házszám"
                                v-model="form.address" class="form-control"
                                :class="{'is-invalid' : form.errors.has('address')}"
                                @keydown="form.errors.clear('address')">
                                <div class="invalid-feedback" v-show="form.errors.has('address')" v-text="form.errors.get('address')"></div>
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Lépcsőház, emelet, ajtó, stb. (nem kötelező)"
                                v-model="form.emelet" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="telefonszam">Telefonszám:</label>
                                <input type="number" placeholder="Pl.: 0630 123 4567" v-model="form.telefonszam"
                                class="form-control"
                                :class="{'is-invalid' : form.errors.has('telefonszam')}"
                                @keydown="form.errors.clear('telefonszam')">
                                <div class="invalid-feedback" v-show="form.errors.has('telefonszam')" v-text="form.errors.get('telefonszam')"></div>
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail cím:</label>
                                <input type="email" v-model="form.email"
                                class="form-control"
                                :class="{'is-invalid' : form.errors.has('email')}"
                                    @keydown="form.errors.clear('email')">
                                    <div class="invalid-feedback" v-show="form.errors.has('email')" v-text="form.errors.get('email')"></div>
                            </div>
                            <div class="justify-content-between">
                                <button type="submit" class="profileSubmitButton">Profil létrehozás</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </modal>
    </div>
</template>
<script>
import Swal from "sweetalert2";
export default {
    props:['user'],
    data(){
        this.userProfile = JSON.parse(this.user);
        return{
            profileHide: false,
            noProfile: false,
            form: new Form({
                vezeteknev: '',
                keresztnev: '',
                iranyitoszam: '',
                email: '',
                varos: '',
                address: '',
                emelet: '',
                telefonszam: '',
            }),
        }
    },
    beforeMount(){
        this.setProfileData();
    },
    methods:{
        setProfileData(){
            if(this.userProfile != null){
                this.form.vezeteknev = this.userProfile.vezeteknev;
                this.form.keresztnev = this.userProfile.keresztnev;
                this.form.iranyitoszam = this.userProfile.iranyitoszam;
                this.form.email = this.userProfile.email;
                this.form.varos = this.userProfile.varos;
                this.form.address = this.userProfile.address;
                this.form.emelet = this.userProfile.emelet;
                this.form.telefonszam = this.userProfile.telefonszam;
            }
        },
        profile(){
            this.profileHide = true;
        },
        profileEdit(){
            this.profileHide = false;
        },
        submitProfileCreate(){
            let data = new FormData();
            data.append('vezeteknev',this.form.vezeteknev);
            data.append('keresztnev',this.form.keresztnev);
            data.append('iranyitoszam',this.form.iranyitoszam);
            data.append('varos',this.form.varos);
            data.append('email',this.form.email);
            data.append('address',this.form.address);
            data.append('emelet',this.form.emelet);
            data.append('telefonszam',this.form.telefonszam);
            axios.post('/profileCreate', data)
            .then((response) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Sikeresen létrehozta a profilját!',
                    showConfirmButton: false,
                    timer: 1500
                })
                this.$modal.hide('user-profile');
              })
             .catch(error => this.form.errors.record(error.response.data));

        },
        submitProfileUpdate(){
            let data = new FormData();
            data.append('vezeteknev',this.form.vezeteknev);
            data.append('keresztnev',this.form.keresztnev);
            data.append('iranyitoszam',this.form.iranyitoszam);
            data.append('varos',this.form.varos);
            data.append('email',this.form.email);
            data.append('address',this.form.address);
            data.append('emelet',this.form.emelet);
            data.append('telefonszam',this.form.telefonszam);
            axios.post('/profileUpdate', data)
            .then((response) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Sikeresen szerkeztette a profilját',
                    showConfirmButton: false,
                    timer: 1500
                })
                this.$modal.hide('user-profile');
              })
             .catch(error => this.form.errors.record(error.response.data));
        },
        //MODEL MEGJELENÍTÉS
        show(){
            this.$modal.show('user-profile');
        },
        //MODEL BEZÁRÁS
        hide(){
            this.$modal.hide('user-profile');
        }
    }
}
</script>
<style scoped>
.nav-link{
    cursor: pointer;
}
.modal-container{
    background-color: rgba(225,198,153,0.5);
    display: flex;

}
.profileSubmitButton{
    background-color: rgba(225,198,153,0.5);
    border: 4px solid rgba(225,198,153);
    border-radius: 30px;
    color: black;
    font-weight: bolder;
    padding: 10px;
}
.profileSubmitButton:hover{
    transform: scale(1.2);
}
.profileSubmitButton:active{
    transform: scale(0.8);
}
.form-control{
    background-color: rgba(225,198,153,0.5);
    color: black;
    font-weight: 900;
}
.userName{
    margin-bottom: 30px;
}
.profileDataContainer{
    border: 2px solid rgba(225,198,153);
    border-radius: 20px;
    box-shadow: 0px 0px 0px 3px rgba(225,198,153,0.8);
    color: black;
    font-weight: 900;
    padding: 30px;
}
.profileData{

    display: flex;
    justify-content: space-between;
}
.profileMenu{
    border: 2px solid rgba(225,198,153);
    border-radius: 20px;
    box-shadow: 0px 0px 0px 3px rgba(225,198,153,0.8);
    margin: 10px;
}
.profileButtonPosition{
    margin-top: 20px;
    margin-bottom: 10px;
    display: flex;
    justify-content: center;
}
.profileButton{
    cursor: pointer;
}
.profileButton:hover{
    transform: scale(1.3);
}
.profileButton:active{
    transform: scale(0.8);
}
</style>
