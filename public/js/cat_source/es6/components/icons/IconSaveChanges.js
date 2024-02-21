import React from 'react'
import PropTypes from 'prop-types'

export const IconSaveChanges = ({size = 16}) => {
  return (
    <svg width={size} height={size} viewBox="0 0 16 16">
      <path
        fill="currentColor"
        fillRule="evenodd"
        clipRule="evenodd"
        d="M11.862 1.195a2.08 2.08 0 1 1 2.943 2.943L8.43 10.513l-.04.04c-.191.192-.36.36-.564.486-.179.11-.374.19-.578.24-.232.055-.471.055-.743.055H5.333a.667.667 0 0 1-.666-.667V9.495c0-.271 0-.51.055-.743a2 2 0 0 1 .24-.578c.124-.204.294-.373.486-.564l.039-.04 6.375-6.375Zm2 .943a.748.748 0 0 0-1.057 0L6.43 8.513c-.253.253-.3.306-.332.358a.667.667 0 0 0-.08.192c-.014.06-.018.13-.018.487V10h.45c.358 0 .428-.004.487-.018a.666.666 0 0 0 .192-.08c.052-.032.105-.078.358-.331l6.375-6.376a.748.748 0 0 0 0-1.057ZM4.506 2h2.827a.667.667 0 0 1 0 1.333h-2.8c-.57 0-.959.001-1.259.026-.292.023-.442.067-.546.12-.25.128-.455.332-.583.582-.053.105-.096.254-.12.547-.024.3-.025.688-.025 1.259v5.6c0 .57 0 .96.025 1.26.024.291.067.44.12.545.128.251.332.455.583.583.104.053.254.096.546.12.3.025.688.025 1.26.025h5.6c.57 0 .959 0 1.259-.025.292-.024.441-.067.546-.12.25-.128.455-.332.582-.583.053-.104.097-.254.12-.546.025-.3.026-.688.026-1.26v-2.8a.667.667 0 0 1 1.333 0v2.828c0 .537 0 .98-.03 1.34-.03.375-.096.72-.26 1.043-.256.502-.664.91-1.166 1.166-.324.165-.668.23-1.043.261-.36.03-.803.03-1.34.03H4.506c-.537 0-.98 0-1.34-.03-.375-.03-.72-.096-1.043-.261a2.667 2.667 0 0 1-1.166-1.165c-.164-.324-.23-.669-.26-1.043-.03-.361-.03-.804-.03-1.34V5.838c0-.536 0-.98.03-1.34.03-.375.096-.72.26-1.043.256-.502.664-.91 1.166-1.165.323-.165.668-.23 1.043-.261.36-.03.803-.03 1.34-.03Z"
      />
      <defs>
        <clipPath id="a">
          <path fill="#fff" d="M0 0h16v16H0z" />
        </clipPath>
      </defs>
    </svg>
  )
}

IconSaveChanges.propTypes = {
  size: PropTypes.number,
}
