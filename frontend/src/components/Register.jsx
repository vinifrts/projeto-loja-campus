import { useState } from 'react'
import { useNavigate } from 'react-router-dom'
import { Eye, EyeOff } from 'lucide-react'

export default function Register() {
  const navigate = useNavigate()
  const [showPassword, setShowPassword] = useState(false)
  const [showConfirmPassword, setShowConfirmPassword] = useState(false)
  const [formData, setFormData] = useState({
    email: '',
    name: '',
    password: '',
    confirmPassword: '',
    vehicleType: '',
  })
  const [errors, setErrors] = useState({})

  const handleInputChange = (e) => {
    const { name, value } = e.target
    setFormData(prev => ({
      ...prev,
      [name]: value
    }))
    // Clear error for this field when user starts typing
    if (errors[name]) {
      setErrors(prev => ({
        ...prev,
        [name]: ''
      }))
    }
  }

  const validateForm = () => {
    const newErrors = {}
    
    if (!formData.email.trim()) {
      newErrors.email = 'Email é obrigatório'
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
      newErrors.email = 'Email inválido'
    }
    
    if (!formData.name.trim()) {
      newErrors.name = 'Nome é obrigatório'
    }
    
    if (!formData.password) {
      newErrors.password = 'Senha é obrigatória'
    } else if (formData.password.length < 6) {
      newErrors.password = 'Senha deve ter pelo menos 6 caracteres'
    }
    
    if (!formData.confirmPassword) {
      newErrors.confirmPassword = 'Confirmação de senha é obrigatória'
    } else if (formData.password !== formData.confirmPassword) {
      newErrors.confirmPassword = 'As senhas não correspondem'
    }
    
    if (!formData.vehicleType) {
      newErrors.vehicleType = 'Selecione um tipo de vínculo'
    }
    
    return newErrors
  }

  const handleSubmit = (e) => {
    e.preventDefault()
    const newErrors = validateForm()
    
    if (Object.keys(newErrors).length === 0) {
      console.log('Register attempt:', formData)
      // Add your registration logic here
    } else {
      setErrors(newErrors)
    }
  }

  return (
    <div className="min-h-screen bg-[#E6F2FD] flex items-center justify-center py-8">
      <div className="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
        {/* Header */}
        <h1 className="text-3xl font-bold text-center mb-8 text-[#000000]">
          Cadastro
        </h1>

        {/* Form */}
        <form onSubmit={handleSubmit} className="space-y-5">
          {/* Email Input */}
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-2">
              Digite seu Email:
            </label>
            <input
              type="email"
              name="email"
              value={formData.email}
              onChange={handleInputChange}
              className={`w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#344BFA] focus:border-transparent placeholder-gray-400 ${
                errors.email ? 'border-red-500' : 'border-gray-300'
              }`}
              placeholder="seu@email.com"
            />
            {errors.email && <p className="text-red-500 text-sm mt-1">{errors.email}</p>}
          </div>

          {/* Name Input */}
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-2">
              Digite seu Nome:
            </label>
            <input
              type="text"
              name="name"
              value={formData.name}
              onChange={handleInputChange}
              className={`w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#344BFA] focus:border-transparent placeholder-gray-400 ${
                errors.name ? 'border-red-500' : 'border-gray-300'
              }`}
              placeholder="Seu nome completo"
            />
            {errors.name && <p className="text-red-500 text-sm mt-1">{errors.name}</p>}
          </div>

          {/* Password Input */}
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-2">
              Digite sua senha:
            </label>
            <div className="relative">
              <input
                type={showPassword ? 'text' : 'password'}
                name="password"
                value={formData.password}
                onChange={handleInputChange}
                className={`w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#344BFA] focus:border-transparent placeholder-gray-400 ${
                  errors.password ? 'border-red-500' : 'border-gray-300'
                }`}
                placeholder="Mínimo 6 caracteres"
              />
              <button
                type="button"
                onClick={() => setShowPassword(!showPassword)}
                className="absolute right-3 top-3 text-gray-500 hover:text-gray-700"
              >
                {showPassword ? (
                  <EyeOff size={20} />
                ) : (
                  <Eye size={20} />
                )}
              </button>
            </div>
            {errors.password && <p className="text-red-500 text-sm mt-1">{errors.password}</p>}
          </div>

          {/* Confirm Password Input */}
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-2">
              Comfirme sua senha:
            </label>
            <div className="relative">
              <input
                type={showConfirmPassword ? 'text' : 'password'}
                name="confirmPassword"
                value={formData.confirmPassword}
                onChange={handleInputChange}
                className={`w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#344BFA] focus:border-transparent placeholder-gray-400 ${
                  errors.confirmPassword ? 'border-red-500' : 'border-gray-300'
                }`}
                placeholder="Confirme sua senha"
              />
              <button
                type="button"
                onClick={() => setShowConfirmPassword(!showConfirmPassword)}
                className="absolute right-3 top-3 text-gray-500 hover:text-gray-700"
              >
                {showConfirmPassword ? (
                  <EyeOff size={20} />
                ) : (
                  <Eye size={20} />
                )}
              </button>
            </div>
            {errors.confirmPassword && <p className="text-red-500 text-sm mt-1">{errors.confirmPassword}</p>}
          </div>

          {/* Vehicle Type Dropdown */}
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-2">
              Selecione o tipo de vínculo:
            </label>
            <select
              name="vehicleType"
              value={formData.vehicleType}
              onChange={handleInputChange}
              className={`w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#344BFA] focus:border-transparent bg-white text-gray-700 ${
                errors.vehicleType ? 'border-red-500' : 'border-gray-300'
              }`}
            >
              <option value="">Selecione uma opção</option>
              <option value="Aluno">Aluno</option>
              <option value="Funcionario">Funcionário</option>
              <option value="Docente">Docente</option>
              <option value="Visitante">Visitante</option>
            </select>
            {errors.vehicleType && <p className="text-red-500 text-sm mt-1">{errors.vehicleType}</p>}
          </div>

          {/* Submit Button */}
          <button
            type="submit"
            className="w-full bg-[#212292] hover:bg-[#344BFA] text-white font-semibold py-3 rounded-lg transition-colors duration-200 mt-6"
          >
            Cadastrar
          </button>
        </form>

        {/* Divider */}
        <hr className="my-6 border-gray-200" />

        {/* Login Link */}
        <div className="text-center">
          <button
            onClick={() => navigate('/login')}
            className="text-sm text-gray-700 hover:text-[#344BFA] transition-colors bg-none border-none cursor-pointer p-0"
          >
            Já possui conta? Clique aqui
          </button>
        </div>
      </div>
    </div>
  )
}
