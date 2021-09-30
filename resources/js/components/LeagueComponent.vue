<template>
    <form @submit="sendFile" enctype="multipart/form-data">
        <div class="form-group">
            <label for="league-name">League Name</label>
            <select class="form-group" v-model="leagueActive">
                <option
                    v-for="league in listLegues.data"
                    :value="league.data.id"
                    :key="league.data.id"
                    >{{ league.data.name }}</option
                >
            </select>
        </div>
        <div class="form-group">
            <label for="file">Seleccionar Archivo</label>
            <input type="file" name="file" id="file" @change="onFileChange" />
        </div>
        <div class="form-group">
            <button class="btn btn-submit" type="submit">Enviar</button>
        </div>
    </form>
</template>

<script>
import axios from "axios";
export default {
    name: "league-component",
    data() {
        return {
            file: null,
            listLegues: [],
            leagueActive: "",
            error: null
        };
    },
    created() {
        this.getLeagues();
    },
    methods: {
        async getLeagues() {
            try {
                const response = await axios.get("/api/leagues");
                this.listLegues = response.data;
            } catch (e) {
                console.log(e.response.data);
                this.error = e.response.data;
                setTimeout(() => {
                    this.error = null;
                }, 2000);
            }
        },
        onFileChange(e) {
            const file = e.target.files[0];
            this.file = file;
        },
        async sendFile(e) {
            e.preventDefault();
            const formData = new FormData();
            formData.append("file", this.file);
            const response = await axios.post("/league/import/teams", formData);
            alert(response.data);
            console.log(response.data);
        }
    }
};
</script>
