import { useState } from 'react'
import { useNavigate } from 'react-router-dom'
import { Eye, EyeOff } from 'lucide-react'

export default function Login() {
  const navigate = useNavigate()
  const [showPassword, setShowPassword] = useState(false)
  const [formData, setFormData] = useState({
    email: '',
    password: '',
  })

  const handleInputChange = (e) => {
    const { name, value } = e.target
    setFormData(prev => ({
      ...prev,
      [name]: value
    }))
  }

  const handleSubmit = (e) => {
    e.preventDefault()
    console.log('Login attempt:', formData)
    // Add your login logic here
  }

  return (
    <div className="min-h-screen bg-[#E6F2FD] flex items-center justify-center">
      <div className="bg-white rounded-lg shadow-lg p-8 w-full max-w-sm">
        {/* Header */}
        <h1 className="text-3xl font-bold text-center mb-8 text-[#000000]">
          Login
        </h1>

        {/* Form */}
        <form onSubmit={handleSubmit} className="space-y-6">
          {/* Email Input */}
          <div>
            <input
              type="email"
              name="email"
              placeholder="Email"
              value={formData.email}
              onChange={handleInputChange}
              className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#344BFA] focus:border-transparent placeholder-gray-400"
              required
            />
          </div>

          {/* Password Input */}
          <div className="relative">
            <input
              type={showPassword ? 'text' : 'password'}
              name="password"
              placeholder="Senha"
              value={formData.password}
              onChange={handleInputChange}
              className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#344BFA] focus:border-transparent placeholder-gray-400"
              required
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

          {/* Forgot Password Link */}
          <div className="text-center">
            <a
              href="#"
              className="text-sm text-gray-700 hover:text-[#344BFA] transition-colors"
            >
              Esqueci minha senha
            </a>
          </div>

          {/* Submit Button */}
          <button
            type="submit"
            className="w-full bg-[#212292] hover:bg-[#344BFA] text-white font-semibold py-3 rounded-lg transition-colors duration-200"
          >
            Entrar
          </button>
        </form>

        {/* Divider */}
        <hr className="my-6 border-gray-200" />

        {/* Register Link */}
        <div className="text-center">
          <button
            onClick={() => navigate('/register')}
            className="text-sm text-gray-700 hover:text-[#344BFA] transition-colors bg-none border-none cursor-pointer p-0"
          >
            Clique aqui para se Cadastrar
          </button>
        </div>
      </div>
    </div>
  )
}
