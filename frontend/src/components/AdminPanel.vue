<template>
  <div class="admin-container">
    <h2>Panel de Administración</h2>

    <!-- Gestión de Usuarios -->
    <div class="admin-section">
      <h3>Gestión de Usuarios</h3>
      <div class="admin-actions">
        <button class="btn" @click="showUserModal = true">
          <i class="fas fa-user-plus"></i>
          Añadir Usuario
        </button>
        <button class="btn" @click="loadUsers">
          <i class="fas fa-sync"></i>
          Actualizar Lista
        </button>
      </div>

      <div class="users-list" v-if="users.length">
        <div v-for="user in users" :key="user.id" class="user-card">
          <div class="user-info">
            <span class="user-name">{{ user.name }}</span>
            <span class="user-email">{{ user.email }}</span>
            <span class="user-role">{{ user.role }}</span>
          </div>
          <div class="user-actions">
            <button class="btn-small" @click="editUser(user)">
              <i class="fas fa-edit"></i>
            </button>
            <button class="btn-small btn-danger" @click="deleteUser(user.id)">
              <i class="fas fa-trash"></i>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Configuración del Sistema -->
    <div class="admin-section">
      <h3>Configuración del Sistema</h3>
      <div class="config-options">
        <div class="config-item">
          <label>Notificaciones por Email</label>
          <input type="checkbox" v-model="config.emailNotifications" />
        </div>
        <div class="config-item">
          <label>Exportación Automática de Informes</label>
          <input type="checkbox" v-model="config.autoExport" />
        </div>
        <div class="config-item">
          <label>Email de Convivencia</label>
          <input
            type="email"
            v-model="config.emailConvivencia"
            placeholder="convivencia@iesmre.com"
          />
        </div>
        <button class="btn" @click="saveConfig">
          <i class="fas fa-save"></i>
          Guardar Configuración
        </button>
      </div>
    </div>

    <!-- Carga de CSV -->
    <div class="admin-section">
      <h3>Carga de Datos</h3>
      <div class="upload-section">
        <div class="upload-item">
          <label>Alumnos (CSV)</label>
          <input type="file" accept=".csv" @change="handleFileUpload($event, 'alumnos')" />
          <button class="btn" @click="uploadCSV('alumnos')" :disabled="!selectedFiles.alumnos">
            <i class="fas fa-upload"></i>
            Subir CSV de Alumnos
          </button>
        </div>
        <div class="upload-item">
          <label>Profesores (CSV)</label>
          <input type="file" accept=".csv" @change="handleFileUpload($event, 'profesores')" />
          <button
            class="btn"
            @click="uploadCSV('profesores')"
            :disabled="!selectedFiles.profesores"
          >
            <i class="fas fa-upload"></i>
            Subir CSV de Profesores
          </button>
        </div>
      </div>
    </div>

    <!-- Modal de Usuario -->
    <div class="modal" v-if="showUserModal">
      <div class="modal-content">
        <h3>{{ editingUser ? 'Editar Usuario' : 'Nuevo Usuario' }}</h3>
        <form @submit.prevent="saveUser">
          <div class="form-group">
            <label>Nombre</label>
            <input type="text" v-model="userForm.name" required />
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" v-model="userForm.email" required />
          </div>
          <div class="form-group">
            <label>Rol</label>
            <select v-model="userForm.role" required>
              <option value="admin">Administrador</option>
              <option value="profesor">Profesor</option>
              <option value="tutor">Tutor</option>
            </select>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn">Guardar</button>
            <button type="button" class="btn btn-secondary" @click="showUserModal = false">
              Cancelar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'AdminPanel',
  data() {
    return {
      users: [],
      showUserModal: false,
      editingUser: null,
      userForm: {
        name: '',
        email: '',
        role: 'profesor',
      },
      config: {
        emailNotifications: false,
        autoExport: false,
        emailConvivencia: 'convivencia@iesmre.com',
      },
      selectedFiles: {
        alumnos: null,
        profesores: null,
      },
    };
  },
  methods: {
    async loadUsers() {
      try {
        const response = await axios.get('http://localhost:8000/api/users');
        this.users = response.data;
      } catch (error) {
        console.error('Error al cargar usuarios:', error);
      }
    },
    async editUser(user) {
      this.editingUser = user;
      this.userForm = { ...user };
      this.showUserModal = true;
    },
    async deleteUser(userId) {
      if (confirm('¿Estás seguro de que quieres eliminar este usuario?')) {
        try {
          await axios.delete(`http://localhost:8000/api/users/${userId}`);
          this.loadUsers();
        } catch (error) {
          console.error('Error al eliminar usuario:', error);
        }
      }
    },
    async saveUser() {
      try {
        if (this.editingUser) {
          await axios.put(`http://localhost:8000/api/users/${this.editingUser.id}`, this.userForm);
        } else {
          await axios.post('http://localhost:8000/api/users', this.userForm);
        }
        this.showUserModal = false;
        this.loadUsers();
      } catch (error) {
        console.error('Error al guardar usuario:', error);
      }
    },
    async saveConfig() {
      try {
        await axios.post('http://localhost:8000/api/config', this.config);
        alert('Configuración guardada correctamente');
      } catch (error) {
        console.error('Error al guardar configuración:', error);
      }
    },
    handleFileUpload(event, type) {
      this.selectedFiles[type] = event.target.files[0];
    },
    async uploadCSV(type) {
      if (!this.selectedFiles[type]) return;

      const formData = new FormData();
      formData.append('file', this.selectedFiles[type]);

      try {
        await axios.post(`http://localhost:8000/api/upload/${type}`, formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });
        alert(`CSV de ${type} subido correctamente`);
        this.selectedFiles[type] = null;
      } catch (error) {
        console.error(`Error al subir CSV de ${type}:`, error);
        alert(`Error al subir el CSV de ${type}`);
      }
    },
  },
  mounted() {
    this.loadUsers();
  },
};
</script>

<style scoped>
.admin-container {
  padding: 2rem;
  max-width: 1200px;
  margin: 0 auto;
}

.admin-section {
  background: white;
  border-radius: 8px;
  padding: 1.5rem;
  margin-bottom: 2rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.admin-section h3 {
  color: #2c3e50;
  margin-bottom: 1rem;
}

.admin-actions {
  display: flex;
  gap: 1rem;
  margin-bottom: 1.5rem;
}

.btn {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1.5rem;
  background-color: #3498db;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.btn:hover {
  background-color: #2980b9;
}

.btn-danger {
  background-color: #e74c3c;
}

.btn-danger:hover {
  background-color: #c0392b;
}

.btn-secondary {
  background-color: #95a5a6;
}

.btn-secondary:hover {
  background-color: #7f8c8d;
}

.users-list {
  display: grid;
  gap: 1rem;
}

.user-card {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  background-color: #f8f9fa;
  border-radius: 4px;
}

.user-info {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
}

.user-name {
  font-weight: 500;
}

.user-email {
  color: #666;
  font-size: 0.9rem;
}

.user-role {
  color: #3498db;
  font-size: 0.8rem;
  text-transform: uppercase;
}

.user-actions {
  display: flex;
  gap: 0.5rem;
}

.btn-small {
  padding: 0.5rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  background-color: #f8f9fa;
  color: #666;
  transition: all 0.3s;
}

.btn-small:hover {
  background-color: #e9ecef;
  color: #2c3e50;
}

.config-options {
  display: grid;
  gap: 1rem;
}

.config-item {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.config-item label {
  flex: 1;
}

input[type='checkbox'] {
  width: 1.2rem;
  height: 1.2rem;
}

input[type='email'] {
  padding: 0.5rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 1rem;
  width: 100%;
}

.upload-section {
  display: grid;
  gap: 1rem;
}

.upload-item {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.modal {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: white;
  padding: 2rem;
  border-radius: 8px;
  width: 100%;
  max-width: 500px;
}

.form-group {
  margin-bottom: 1rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  color: #2c3e50;
}

.form-group input,
.form-group select {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 1rem;
}

.form-actions {
  display: flex;
  gap: 1rem;
  margin-top: 1.5rem;
}

@media (max-width: 768px) {
  .admin-actions {
    flex-direction: column;
  }

  .btn {
    width: 100%;
  }

  .config-item {
    flex-direction: column;
    align-items: flex-start;
  }

  .form-actions {
    flex-direction: column;
  }
}
</style>
